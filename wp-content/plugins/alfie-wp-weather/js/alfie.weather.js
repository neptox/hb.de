/*

 ============ appcuarium ============

 Alfie ® Platform JS SDK

 ====== Apps outside the box.® ======

 ------------------------------------
 Copyright © 2012 Appcuarium
 ------------------------------------

 apps@appcuarium.com
 @author Sorin Gheata
 @version 1.0.6

 ====================================

 Alfie Weather plugin

 */

// Create wrapper for non-supporting browsers
if ( typeof Object.create !== 'function' ) {

    Object.create = function ( obj ) {
        function F() {};
        F.prototype = obj;
        return new F();
    };

}

(function ( $, window, document, undefined ) {

    var Alfie = {
        init: function ( options, elem ) {

            var me = this;
            me.elem = elem;
            me.$elem = $( elem );
            me.date = new Date();
            me.options = $.extend( {}, $.fn.alfie.options, options );
            me.random = me.date.getFullYear() + me.date.getMonth() + me.date.getDay() + me.date.getHours();
            me.refresh_in = me.random + 3660;
            me.now = $.now().toString();
            me.timestamp = me.now.substring( 0, 10 );

            me.next_refresh = sessionStorage.getItem( 'next_refresh' );
            me.query = '';
            me.searchInput = $( '#widgets-right #search-location' );
            me.template = $.trim( $( '#weather-template' ).html() );
            me.route();
        },

        // Receive scope and action and route input based on values
        route: function () {
            var me = this,
                action = me.options.action;
            return me.executeQuery( action );

        },

        // Execute called function
        executeQuery: function ( action ) {
            var me = this;

            $.each( action, function ( key, value ) {

                return me[ key ].call( me, value );

            } );

        },

        // Search for a location
        searchDelayed: function () {
            var me = this;
            me.searchInput.on( 'keyup', me.search );
        },

        // Get coordinates
        get_coordinates_by_ip: function () {
            var me = this,
                pool = alfie.path + '/alfie-wp-weather/get_coordinates.php',
                dfd = $.Deferred();

            $.when( me.fetch( pool, 'json', null ) ).then( function ( response ) {
                dfd.resolve( response );
            } );
            return dfd.promise();
        },

        // Get the WOEID by passing lat and lng coordinates
        get_woeid_by_coordinates: function ( lat, lng ) {
            var me = this,
                now = new Date(),
                random = now.getFullYear() + now.getMonth() + now.getDay() + now.getHours(),
                query = 'select * from geo.placefinder where text="' + lat + ', ' + lng + '" and gflags="R"',
                api = 'http://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent( query ) + '&rnd=' + random + '&format=json&callback=?',
                dfd = $.Deferred();

            $.when( me.fetch( api, 'json', null ) ).then( function ( response ) {
                dfd.resolve( response );
            } );

            return dfd.promise();
        },

        // Convert IP address to WOEID
        ip_to_woeid: function () {

            var me = this,
                dfd = $.Deferred(),
                client_position = JSON.parse( sessionStorage.getItem( 'client_position' ) );

            // Client position cache is present, data is valid and ready to be used
            if ( client_position ) {
                if ( client_position.data.lat !== 0 && client_position.data.lng !== 0 ) {
                    $.when( me.get_woeid_by_coordinates( client_position.data.lat, client_position.data.lng ) ).then( function ( woeid_response ) {

                        dfd.resolve( woeid_response.query.results.Result.woeid );

                    } );
                }
                else {
                    dfd.resolve( 0 );
                }

            }

            // Client position cache is present, but it's not returning actual positioning data
            else {

                $.when( me.get_coordinates_by_ip() ).then( function ( response ) {

                    // No response available
                    if ( response.data.lat == 0 && response.data.lng == 0 ) {

                        dfd.resolve( 0 );

                    } else {

                        $.when( me.get_woeid_by_coordinates( response.data.lat, response.data.lng ) ).then( function ( woeid_response ) {

                            dfd.resolve( woeid_response.query.results.Result.woeid );

                        } );
                    }

                    sessionStorage.setItem( 'client_position', JSON.stringify( response ) );

                } );
            }

            return dfd.promise();

        },

        // Delayed search function
        search: function () {

            var self = Alfie,
                input = this,
                now = new Date(),
                random = now.getFullYear() + now.getMonth() + now.getDay() + now.getHours(),
                query = 'select * from geo.places where text="' + input.value + '"',
                api = 'http://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent( query ) + '&rnd=' + random + '&format=json&callback=?',
                dfd = $.Deferred();

            clearTimeout( self.timer );

            self.timer = ( input.value.length >= 3 ) && setTimeout( function () {

                $.when( self.fetch( api, 'json', null ) ).then( function ( response ) {

                    $.when( self.build( response ) ).done( function ( resp ) {
                        $( '#widgets-right #cities' ).html( resp );
                    } );
                    dfd.resolve();
                } );

            }, 400 );

            return dfd.promise();
        },

        // Get the weather
        get_weather: function ( data ) {

            var me = this,
                weather_by_location = data.params.auto_location,
                locale = data.params.locale,
                server_timestamp = data.params.timestamp,
                timestamp = new Date( server_timestamp * 1000 ),
                hours = timestamp.getUTCHours(),
                day = timestamp.getUTCDate(),
                month = timestamp.getUTCMonth(),
                year = timestamp.getUTCFullYear(),
                now = new Date( Date.UTC( year, month, day, hours ) ),
                now_timestamp = ( now.getTime() / 1000 ),
                refresh_timestamp = now_timestamp + 3600,
                next_refresh = sessionStorage.getItem( 'next_refresh' );

            // Weather by user position enabled
            if ( weather_by_location == true ) {

                // Modern browser detected
                if ( window.sessionStorage ) {

                    // Location WOEID is stored
                    if ( sessionStorage.getItem( 'location_woeid' ) && sessionStorage.getItem( 'location_woeid' ) !== '0' ) {

                        // Set WOEID based on stored value
                        data.params.woeid = parseInt( sessionStorage.getItem( 'location_woeid' ) );

                        var session_object_name = 'weatherData_' + data.params.woeid + '_' + locale,
                            session_object = JSON.parse( sessionStorage.getItem( session_object_name ) );

                        // Data is still valid
                        if ( server_timestamp < refresh_timestamp ) {

                            // Session storage and weather data object are available
                            if ( sessionStorage.getItem( session_object_name ) ) {

                                // Build the widget
                                $.when( me.build_weather_widget( session_object ) ).then( function ( response ) {

                                    if ( typeof me.options.onComplete === 'function' ) {
                                        me.options.onComplete.apply( this, [response] );
                                    }

                                } );
                            }

                            else if ( !sessionStorage.getItem( session_object_name ) ) {

                                // Build the widget
                                $.when( me.refresh_weather_data( data ).then( function ( weather_data ) {

                                    // If valid response is received and session storage is available, store the object
                                    if ( weather_data && window.sessionStorage ) {
                                        sessionStorage.setItem( session_object_name, JSON.stringify( weather_data ) );
                                    }

                                    // Build the widget
                                    $.when( me.build_weather_widget( weather_data ) ).then( function ( response ) {

                                        if ( typeof me.options.onComplete === 'function' ) {
                                            me.options.onComplete.apply( this, [response] );
                                        }

                                    } );

                                } ) );
                            }
                        }

                        // Data expired, get a fresh set of data
                        else {

                            // Clear old data
                            sessionStorage.clear();

                            // Get fresh data from server
                            $.when( me.refresh_weather_data( data ).then( function ( weather_data ) {

                                // Build the widget
                                $.when( me.build_weather_widget( weather_data ) ).then( function ( response ) {

                                    if ( typeof me.options.onComplete === 'function' ) {
                                        me.options.onComplete.apply( this, [response] );
                                    }

                                } );

                            } ) );
                        }
                    }

                    // Session storage WOEID is not present
                    else {

                        // Get the WOEID
                        $.when( me.ip_to_woeid() ).then( function ( response ) {

                            if ( response !== 0 ) {

                                // Set the WOEID based on response

                                data.params.woeid = response;

                            }

                            // Set the WOEID session storage value
                            sessionStorage.setItem( 'location_woeid', response );

                            var session_object_name = 'weatherData_' + data.params.woeid + '_' + locale,
                                session_object = JSON.parse( sessionStorage.getItem( session_object_name ) );

                            // Data is still valid
                            if ( server_timestamp < refresh_timestamp ) {

                                // Weather data object are available
                                if ( sessionStorage.getItem( session_object_name ) ) {

                                    // Build the widget
                                    $.when( me.build_weather_widget( session_object ) ).then( function ( response ) {

                                        if ( typeof me.options.onComplete === 'function' ) {
                                            me.options.onComplete.apply( this, [response] );
                                        }

                                    } );

                                }

                                // Weather data from session is not available, get a fresh set from server
                                else {

                                    $.when( me.refresh_weather_data( data ).then( function ( weather_data ) {

                                        // If valid response is received and session storage is available, store the object
                                        if ( weather_data && window.sessionStorage ) {
                                            sessionStorage.setItem( session_object_name, JSON.stringify( weather_data ) );
                                        }

                                        // Build the widget
                                        $.when( me.build_weather_widget( weather_data ) ).then( function ( response ) {

                                            if ( typeof me.options.onComplete === 'function' ) {
                                                me.options.onComplete.apply( this, [response] );
                                            }

                                        } );
                                    } ) );
                                }
                            }

                            // Data expired, get a fresh set of data
                            else {

                                // Clear old data
                                sessionStorage.clear();

                                // Get fresh data from server
                                $.when( me.refresh_weather_data( data ).then( function ( weather_data ) {

                                    // Build the widget
                                    $.when( me.build_weather_widget( weather_data ) ).then( function ( response ) {

                                        if ( typeof me.options.onComplete === 'function' ) {
                                            me.options.onComplete.apply( this, [response] );
                                        }

                                    } );
                                } ) );
                            }
                        } );
                    }

                }

                // Ice Age mode
                else {
                    $.when( me.ip_to_woeid() ).then( function ( response ) {

                        // Set the WOEID based on response
                        data.params.woeid = response;

                        // Get fresh data from server
                        $.when( me.refresh_weather_data( data ).then( function ( weather_data ) {

                            // Build the widget
                            $.when( me.build_weather_widget( weather_data ) ).then( function ( response ) {

                                if ( typeof me.options.onComplete === 'function' ) {
                                    me.options.onComplete.apply( this, [response] );
                                }

                            } );
                        } ) );
                    } );
                }
            }

            // Weather by custom position enabled
            else {

                if ( window.sessionStorage ) {
                    var session_object_name = 'weatherData_' + data.params.woeid + '_' + locale,
                        session_object = JSON.parse( sessionStorage.getItem( session_object_name ) );
                }

                // Data is still valid
                if ( server_timestamp < refresh_timestamp ) {

                    // Session storage and weather data object are available
                    if ( window.sessionStorage && sessionStorage.getItem( session_object_name ) ) {

                        // Build the widget
                        $.when( me.build_weather_widget( session_object ) ).then( function ( response ) {

                            if ( typeof me.options.onComplete === 'function' ) {
                                me.options.onComplete.apply( this, [response] );
                            }

                        } );
                    }

                    else if ( window.sessionStorage && !sessionStorage.getItem( session_object_name ) ) {

                        // Build the widget
                        $.when( me.refresh_weather_data( data ).then( function ( weather_data ) {

                            // If valid response is received and session storage is available, store the object
                            if ( weather_data && window.sessionStorage ) {
                                sessionStorage.setItem( session_object_name, JSON.stringify( weather_data ) );
                            }

                            // Build the widget
                            $.when( me.build_weather_widget( weather_data ) ).then( function ( response ) {

                                if ( typeof me.options.onComplete === 'function' ) {
                                    me.options.onComplete.apply( this, [response] );
                                }

                            } );
                        } ) );
                    }

                    // Ice Age browser detected, get feed from source
                    else {

                        // Get fresh data from server
                        $.when( me.refresh_weather_data( data ).then( function ( weather_data ) {

                            // Build the widget
                            $.when( me.build_weather_widget( weather_data ) ).then( function ( response ) {

                                if ( typeof me.options.onComplete === 'function' ) {
                                    me.options.onComplete.apply( this, [response] );
                                }

                            } );
                        } ) );
                    }
                }

                // Data expired, get a fresh set of data
                else {

                    // Clear old data
                    sessionStorage.clear();

                    // Get fresh data from server
                    $.when( me.refresh_weather_data( data ).then( function ( weather_data ) {

                        // Build the widget
                        $.when( me.build_weather_widget( weather_data ) ).then( function ( response ) {

                            if ( typeof me.options.onComplete === 'function' ) {
                                me.options.onComplete.apply( this, [response] );
                            }

                        } );
                    } ) );
                }
            }
        },

        // Get a fresh set of data
        refresh_weather_data: function ( data ) {

            var me = this,
                dfd = $.Deferred();

            $.when( me.fetch( alfie.path + '/alfie-wp-weather/getfeed.php', 'json', data.params ) ).then( function ( response ) {
                dfd.resolve( response );
            } );

            return dfd.promise();
        },
        getTimeAsDate: function ( t ) {

            var d = new Date();

            return new Date( d.toDateString() + ' ' + t );

        },

        // Build the widget HTML
        build_weather_widget: function ( results ) {

            var me = this,
                dfd = $.Deferred(),
                widgetTemplate = $.trim( $( '#widget-template' ).html() ),
                widgetEnvelope = $( '<ul />', {
                    class: 'loaded'
                } ),
                daynight,
                obj = $.map( results, function ( result, i ) {

                    var wpd = result.item.pubDate,
                        n = wpd.indexOf( ":" ),
                        tpb = me.getTimeAsDate( wpd.substr( n - 2, 8 ) ),
                        tsr = me.getTimeAsDate( result.astronomy.sunrise ),
                        tss = me.getTimeAsDate( result.astronomy.sunset ),
                        image_bg = 'http://l.yimg.com/a/i/us/nws/weather/gr/{{condition_code}}';

                    // Get night or day
                    if ( tpb > tsr && tpb < tss ) {
                        daynight = 'day';
                    } else {
                        daynight = 'night';
                    }

                    var wd = result.wind.direction;
                    if ( wd >= 348.75 && wd <= 360 ) {
                        wd = "N"
                    }
                    if ( wd >= 0 && wd < 11.25 ) {
                        wd = "N"
                    }
                    if ( wd >= 11.25 && wd < 33.75 ) {
                        wd = "NNE"
                    }
                    if ( wd >= 33.75 && wd < 56.25 ) {
                        wd = "NE"
                    }
                    if ( wd >= 56.25 && wd < 78.75 ) {
                        wd = "ENE"
                    }
                    if ( wd >= 78.75 && wd < 101.25 ) {
                        wd = "E"
                    }
                    if ( wd >= 101.25 && wd < 123.75 ) {
                        wd = "ESE"
                    }
                    if ( wd >= 123.75 && wd < 146.25 ) {
                        wd = "SE"
                    }
                    if ( wd >= 146.25 && wd < 168.75 ) {
                        wd = "SSE"
                    }
                    if ( wd >= 168.75 && wd < 191.25 ) {
                        wd = "S"
                    }
                    if ( wd >= 191.25 && wd < 213.75 ) {
                        wd = "SSW"
                    }
                    if ( wd >= 213.75 && wd < 236.25 ) {
                        wd = "SW"
                    }
                    if ( wd >= 236.25 && wd < 258.75 ) {
                        wd = "WSW"
                    }
                    if ( wd >= 258.75 && wd < 281.25 ) {
                        wd = "W"
                    }
                    if ( wd >= 281.25 && wd < 303.75 ) {
                        wd = "WNW"
                    }
                    if ( wd >= 303.75 && wd < 326.25 ) {
                        wd = "NW"
                    }
                    if ( wd >= 326.25 && wd < 348.75 ) {
                        wd = "NNW"
                    }

                    if ( result.item.condition.code == 20 || result.item.condition.code == 3200 ) {
                        image_bg = alfie.path + '/alfie-wp-weather/img/' + result.item.condition.code;
                    } else {
                        image_bg = 'http://l.yimg.com/a/i/us/nws/weather/gr/' + result.item.condition.code;
                    }
                    var widgetHTML = widgetTemplate
                        .replace( /{{city}}/ig, result.location.city )
                        .replace( /{{country}}/ig, result.location.country )
                        .replace( /{{image_bg}}/ig, image_bg )
                        .replace( /{{currentTemp}}/ig, result.item.condition.temp )
                        .replace( /{{condition_code}}/ig, result.item.condition.code )
                        .replace( /{{daynight}}/ig, daynight.substring( 0, 1 ) )
                        .replace( /{{condition}}/ig, result.item.condition.text )
                        .replace( /{{high}}/ig, result.item.forecast.today.high )
                        .replace( /{{low}}/ig, result.item.forecast.today.low )
                        .replace( /{{wind}}/ig, result.wind.speed )
                        .replace( /{{wind_direction}}/ig, wd )
                        .replace( /{{speed_unit}}/ig, result.units.speed )
                        .replace( /{{distance_unit}}/ig, result.units.distance )
                        .replace( /{{pressure_unit}}/ig, result.units.pressure )
                        .replace( /{{temperature_unit}}/ig, result.units.speed )
                        .replace( /{{humidity}}/ig, result.atmosphere.humidity )
                        .replace( /{{visibility}}/ig, result.atmosphere.visibility )
                        .replace( /{{sunrise}}/ig, result.astronomy.sunrise )
                        .replace( /{{sunset}}/ig, result.astronomy.sunset )
                        .replace( /{{day_one}}/ig, result.item.forecast.today.day )
                        .replace( /{{day_two}}/ig, result.item.forecast.tomorrow.day )
                        .replace( /{{forecast_one_high}}/ig, result.item.forecast.today.high )
                        .replace( /{{forecast_one_low}}/ig, result.item.forecast.today.low )
                        .replace( /{{forecast_two_high}}/ig, result.item.forecast.tomorrow.high )
                        .replace( /{{forecast_two_low}}/ig, result.item.forecast.tomorrow.low )
                        .replace( /{{forecast_one_code}}/ig, result.item.forecast.today.code )
                        .replace( /{{forecast_two_code}}/ig, result.item.forecast.tomorrow.code )
                        .replace( /{{yahoo_logo}}/ig, result.image.url );

                    dfd.resolve( widgetHTML );

                } );

            return dfd.promise();
        },

        // AJAX fetcher
        fetch: function ( url, encoding, params ) {

            var me = this,
                ajaxEncoding = url.encoding || encoding,
                ajaxUrl = url.url || url,
                ajaxParams = url.params || params;

            return $.ajax( {

                url: ajaxUrl,
                type: 'POST',
                async: true,
                cache: false,
                data: ajaxParams,
                dataType: ajaxEncoding

            } );
        },

        // Build the query object
        build: function ( results ) {

            var me = this,
                dfd = $.Deferred(),
                template = $.trim( $( '#weather-template' ).html() ),
                entryEnvelope = $( '<ul />', {
                    class: 'loaded'
                } );

            var objects = $.map( results.query.results, function ( result, i ) {

                $.each( result, function ( index, value ) {
                    var entryHTML = template
                        .replace( /{{woeid}}/ig, value.woeid )
                        .replace( /{{location}}/ig, value.name )
                        .replace( /{{country}}/ig, value.country.content );

                    var results = $( entryEnvelope ).append( entryHTML )[0];
                    dfd.resolve( results );
                } );

            } );

            return dfd.promise();
        }
    };

    $.fn.alfie = function ( options ) {
        var alfie_framework = Object.create( Alfie );
        if ( alfie_framework[options] ) {
            return alfie_framework[options].apply( this, Array.prototype.slice.call( arguments, 1 ) );
        } else if ( typeof options === 'object' || !options ) {
            return this.each( function () {

                alfie_framework.init( options, this );

                $.data( this, 'alfie', alfie_framework );
            } );
        }
    };

    $.fn.alfie.options = {};

})( jQuery, window, document );
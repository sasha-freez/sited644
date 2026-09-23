/**
 *  Package: jQuery PubSub
 *    a lightweight and fast jQuery Publish/Subscribe system
 *    based on the jQuery plugin by Peter Higgins (dante@dojotoolkit.org)
 *    http://higginsforpresident.net/js/jq.pubsub.js
*/
(function(window) {
  var subscriptions = {},
      cache = {},
      we,
      ops = Object.prototype.toString,
      aps = Array.prototype.slice;
  
  (window.espn || (window.espn = {}) );
  we = window.espn;
  //  Method: jQuery.publish
  //    Publishes a topic
  //
  //  Paramenters:
  //    topic - (String) the topic you want to publish
  //    arguments - (Array) the arguments you wish to pass to any subscribed listeners
  //

  we.publish = function(topic, args) {
    var i;

    // make sure args is an array
    ( args && (ops.call(args) === "[object Array]") ) || ( args = [] );

    // cache this publish for catchup events
    ( cache[topic] || (cache[topic] = []) ).push(args);
    
    if(!subscriptions[topic]) {
      // just exit out of this function
      return;
    }
    i = subscriptions[topic].length;

    // apply this publish to currently subscribed callbacks
    while(--i >= 0) {
      subscriptions[topic][i].apply(this,args);
    }
  };
  //  Method: jQuery.subscribe
  //    Subscribes a listener to a specific topic
  //
  //  Paramenters:
  //    topic - (String) the topic you want to subscribe to
  //    settings - (Object) options settings - OPTIONAL
  //    callback - (Function) the function to execute when the topic is published
  //
  //  Returns:
  //    handle - (Array) a handle used to unsubscribe this listener
  //
  //  Usage:
  //    (start code)
  //    // This is the most basic and most used example
  //    var subscribeHandle = $.subscribe('some.topic.name', function() { /* callback code here */});
  //
  //    // You can make the subscription more advanced by passing in some options
  //    var subscribeHandle = $.subscribe(
  //      'some.topic.name',
  //      { 
  //        "catchup": true,  // we want to make sure to trigger previous publishes as well 
  //        "first": 5,       // only give us the first X publishes \__ DO NOT SPECIFY BOTH 
  //        "last": 5         // only give us the last X publishes  /
  //      }, 
  //      function () { /* callback code in here */ }
  //    );
  //    (end code)
  we.subscribe = function(topic) {
    var l, i, options, callback, iCache,
        args = aps.call(arguments,1); // strip off the first argument (topic)
    
    // let's assign the options and callback
    options = (ops.call(args[0]) === "[object Object]") ? args[0] : {};
    callback = (ops.call(args[0]) === "[object Function]") ? args[0] : args[1];

    // initialize the subscription array for this topic if it does not exist
    ( subscriptions[topic] || (subscriptions[topic] = []) ).push(callback);
    
    if(!!options.catchup) {
      // we need to trigger all previous publishes prior to this point in time
      if(!!cache[topic]) {

        iCache = cache[topic];
        if(!!options.first) {
          iCache = aps.call(iCache,0,options.first);
        } else if(!!options.last) {
          iCache = aps.call(iCache,-options.last);
        }
        i=-1; 
        l = iCache.length;
        while(++i < l){
          callback.apply(this,iCache[i]);
        }
        // we don't need this hanging around
        iCache = null;
      }
    }

    // return the hook for unsubscribe
    return [topic,callback];
  };
  //  Method: jQuery.unsubscribe
  //    Unsubscribes a listener to a specific topic
  //
  //  Paramenters:
  //    handle - (Array) the handle returned when you subscribed to a topic
  //
  we.unsubscribe = function(handle) {
    var t = handle[0],
        i = subscriptions[t].length;
    while(--i >= 0) {
      if(subscriptions[t][i] == handle[1]) {
        subscriptions[t].splice(i,1);
      }
    }
  };

  if(!!window.jQuery) {
    jQuery.publish = we.publish;
    jQuery.subscribe = we.subscribe;
    jQuery.unsubscribe = we.unsubscribe;
  }
})(window);

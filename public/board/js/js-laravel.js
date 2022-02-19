// (function(root, factory) {
//   if (typeof define === 'function' && define.amd) {
//     define([], factory);
//   } else if (typeof module === 'object' && module.exports) {
//     module.exports = factory();
//   } else {
//     root.returnExports = factory();
//   }
// }(typeof self !== 'undefined' ? self : this, function() {
//   var promise = Promise;
//   var resolve = promise.resolve;
//   var reject = promise.reject;
//   var jsLaravel = function(selector) {
//     return new jsLaravel.fn.init(selector)
//   }
//   jsLaravel.fn = jsLaravel.prototype = {
//     constructor: jsLaravel,
//     resolve: function() {
//       return resolve.call(self);
//     },
//     reject: function() {
//       return reject.call(self);
//     },
//     get: function() {
//       return self;
//     }
//     ,
//     init: function(selector) {
//       if (typeof (selector) === 'string') {
//         self[0] = document.querySelector(selector);
//         return self;
//       }
//       return self;
//     }
//   };

//   return this.jsLaravel = jsLaravel
// }))


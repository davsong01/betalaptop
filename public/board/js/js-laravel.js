(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    define([], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory();
  } else {
    root.returnExports = factory();
  }
}(typeof self !== 'undefined' ? self : this, function() {
  var jsLaravel = function(selector, options = {}) {
    return jsLaravel.fn.init(selector, options)
  }
  jsLaravel.fn = jsLaravel.prototype = {
    init: function(selector, options) {
      try {
        let element = typeof selector === 'string' ? document.querySelector(selector) : selector;
        let form = {};

        if (typeof HTMLElement === "object" ? element instanceof HTMLElement : //DOM2
          element && typeof element === "object" && element !== null && element.nodeType === 1 && typeof element.nodeName === "string") {
          if (element instanceof HTMLFormElement) {
            form = new FormData(element);
          } else if (element.querySelector('form') && element.querySelector('form') instanceof HTMLFormElement) {
            element = element.querySelector('form');
            form = new FormData(element);
          } else {
            throw new Error(`ElementMisMatched: Element type HTML${this.toPascalCase(element.tagName)}Element passed expected HTMLFormElement`)
          }
        }
        const { action, method, mode, cache, credentials, headers, redirect, referrerPolicy, body } = options;
        return fetch(action ? action : element.getAttribute('action'), {
          method: method ? method : element.getAttribute('method') ? element.getAttribute('method') : 'POST',
          body: body ? body : form,
          ...(mode ? { mode } : {}),
          ...(cache ? { cache } : {}),
          ...(credentials ? { credentials } : {}),
          ...(headers ? { headers } : {}),
          ...(redirect ? { redirect } : {}),
          ...(referrerPolicy ? { referrerPolicy } : {}),
        });
      } catch (error) {
        console.error("Error occurred: ", error)
      }
    },
    toPascalCase: function(str) {
      return str.charAt(0).toLocaleUpperCase() + str.substr(1).toLocaleLowerCase()
    }
  };

  jsLaravel.version = "0.0.1-beta";

  if (self.jsLaravel === undefined) {
    self.jsLaravel = jsLaravel
  }
  return self.jsLaravel = jsLaravel
}))
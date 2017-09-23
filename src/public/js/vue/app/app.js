/**
 * PHP library for adding addition of complements for Eliasis Framework.
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Eliasis-Framework/Module
 * @since      1.0.8
 */
var FILTERS = document.getElementById('complements-filter');

var COMPLEMENT = {

   app:    FILTERS.getAttribute('data-app'),
   type:   FILTERS.getAttribute('data-complement'),
   lang:   FILTERS.getAttribute('data-language'),
   sort:   FILTERS.getAttribute('data-sort'),
   filter: FILTERS.getAttribute('data-filter'),
   urls:   FILTERS.getAttribute('data-external'),
   states: {

      'active': {
         'en': 'active',
         'es': 'activo',
      },
      'inactive': {
         'en': 'activate',
         'es': 'activar',
      },
      'installed': {
         'en': 'activate',
         'es': 'activar',
      },
      'outdated': {
         'en': 'update',
         'es': 'actualizar',
      },
      'uninstalled': {
         'en': 'install',
         'es': 'instalar',
      },
      'uninstall': {
         'en': 'uninstall',
         'es': 'desinstalar',
      }
   }
};
 
COMPLEMENT = Object.freeze(COMPLEMENT);

function setUrl(params) {

   var url = window.location.href.split('#')[0];

   url += (!url.indexOf('?') ? '?' : '&') + 'vue=true';

   Object.keys(params).forEach(function(key) {

      url += '&' + key + '=' + params[key];
   });

   return url;
}

Vue.component('state-buttons', {

   data: function () {

      return {

         id:            false,
         state:         false,
         message:       false,
         removeButton:  false,
         isActive:      false,
         isInactive:    false,
         isOutdated:    false,
         isInstall:     false,
         isUninstalled: false,
         isUninstall:   false,
         theErrors:     []
      }
   },

   watch: {

      'theErrors': function() {

         this.$emit('input', this.theErrors);
      }
   },

   created: function() {

      this.removeButton = COMPLEMENT.states['uninstall'][COMPLEMENT.lang];
   },

   methods: {

      resetStates: function() {

         this.isActive       = false;
         this.isInactive     = false;
         this.isOutdated     = false;
         this.isInstall      = false;
         this.isUninstalled  = false;
         this.isUninstall    = false;
      },

      changeState: function() {

         this.id = this.complementId;

         var request = 'change-state';

         if (this.state == 'uninstalled' || this.state == 'outdated') {

            this.resetStates();

            this.isInstall = true;

            request = 'install';
         }

         var url = setUrl({

            request:    request,
            app:        COMPLEMENT.app,
            complement: COMPLEMENT.type,
            id:         this.id,
            state:      this.state,
            external:   COMPLEMENT.urls
         });

         this.$http.get(url).then(function(response) {

            var state = response.body.state;

            this.resetStates();

            this.state = (state === false) ? this.state : state;

            if (typeof response.body.version !== 'undefined') {

               var version = document.getElementById(this.complementId).getElementsByClassName('complement-version')[0];

               this.fadeIn(version);

               version.innerHTML = response.body.version;
            }

            this.theErrors = response.body.errors;
         });
      },

      uninstall: function() {

         this.id = this.complementId;

         this.isUninstall = true;

         var url = setUrl({

            request:    'uninstall',
            app:        COMPLEMENT.app,
            complement: COMPLEMENT.type,
            id:         this.id,
            external:   COMPLEMENT.urls
         });

         this.$http.get(url).then(function(response) {
        
            var that = this;
           
            setTimeout(function() {

               var state = response.body.state;

               that.state = (state === false) ? that.state : state;

               that.theErrors = response.body.errors;

            }, 1000);
         });
      },

      /**
       * @author @zackbloom
       * @author @adamfschwartz 
       * @link http://youmightnotneedjquery.com/
       */
      fadeIn: function(el) {

        el.style.opacity = 0;

        var tick = function() {

          el.style.opacity = +el.style.opacity + 0.01;

          if (+el.style.opacity < 1) {

            (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16)
          }
        };

        tick();
      }
   },

   computed: {

      changeButtonState: function () {
      
         this.resetStates();
         
         this.state = this.state ? this.state : this.complementState;

         this.message = COMPLEMENT.states[this.state][COMPLEMENT.lang];

         switch (this.state) {

            case 'active':      this.isActive      = true; break;
            case 'inactive':    this.isInactive    = true; break;
            case 'outdated':    this.isOutdated    = true; break;
            case 'uninstalled': this.isUninstalled = true; break;
         }

         return this.message;
      }
   },

   props: ['complementId', 'complementState', 'errors'],
})

var app = new Vue({

   el: '#eliasis-complements',

   data: {

      complements: [],
      errors:  []
   },

   created: function() {

      var url = setUrl({

         request:    'load-complements',
         app:        COMPLEMENT.app,
         complement: COMPLEMENT.type,
         sort:       COMPLEMENT.sort,
         filter:     COMPLEMENT.filter,
         external:   COMPLEMENT.urls
      });

      this.$http.get(url).then(function(response) {

         this.complements = response.body.complements;

         this.errors = response.body.errors;
      });
   }
});

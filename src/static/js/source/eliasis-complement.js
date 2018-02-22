new Vue({
  el: "#eliasis-complements",
  components: { 
    'VueModuleManager': VueModuleManager.VueModuleManager, 
    'VueSimpleNotify': VueSimpleNotify.VueSimpleNotify
  },
  data () {
    return {
      items: [],
      translations: null,
      delay: 1000,
      complement: null,
      url: null,
      errors: [],
      options: null,
      http: {
         emulateJSON: true
      }
    }
  },
  mounted: function mounted () {
    this.translations = this.options.translations
    this.sendRequest('load-complements', null, null)
  },
  methods: {
    setConfiguration: function setConfiguration (options) {
      this.options = {
        'id': options['id'],
        'app': options['app'],
        'sort': options['sort'],
        'nonce': options['nonce'],
        'state': options['state'],
        'filter': options['filter'],
        'request': options['request'],
        'external': options['external'],
        'language': options['language'],
        'complement': options['complement'],
        'translations': options['translations']
      }
    },
    sendRequest: function sendRequest(request, state, index) {
      this.options.state = state
      this.options.request = request
      this.options.id = index !== null ? this.items[index].id : null
      var url = window.location.href.split('#')[0];
      this.$http.post(url, this.options, this.http).then(function (response) {
        this.updateItems(response.body, index)
        this.errors = response.body.errors
      }, function (response) {
          console.error(response)
      })
    },
    updateItems: function updateItems(response, index) {
      if (typeof response.complements !== 'undefined') {
        this.items = response.complements
      } else if (typeof response.complement !== 'undefined') {
        this.items[index].name = response.complement.name
        this.items[index].version = response.complement.version
        this.items[index].description = response.complement.description
        this.items[index].state = response.complement.state
        this.items[index].url = response.complement.url
        this.items[index].image = response.complement.image
      } else if (typeof response.state !== 'undefined') {
        this.items[index].state = response.state
      }
    },
    onActive: function onActive (index) {
      this.sendRequest('change-state', 'active', index)
    },
    onInactive: function onInactive (index) {
      this.sendRequest('change-state', 'inactive', index)
    },
    onUpdate: function onUpdate (index) {
      this.sendRequest('update', 'update', index)
    },
    onInstall: function onInstall (index) {
      this.sendRequest('install', 'install', index)
    },
    onUninstall: function onUninstall (index) {
      this.sendRequest('uninstall', 'uninstall', index)
    }
  }
})

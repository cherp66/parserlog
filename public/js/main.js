
new Vue({
  el: '#app',

    data: {
        error: null,
        username: null,
        password: null,
        name: null,
        token: null,
        auth: false,
        gridColumns: ["ip", "datetime", "query", "status", "referer", "useragent"],
        gridData: null
    },
  
    methods: {
        login (){ 
          axios
            .post('/login', {
               username: this.username,
               password: this.password
            })
            .then(response => (
                this.error = response.data.errors,
                this.token = response.data.token,
                this.getContent()
            ));
        return false;    
       },
       
        logout (){
          axios
            .post('/logout', {token: localStorage.getItem('token')})
            .then(response => (
                this.token = '',
                this.gridData = '',
                localStorage.removeItem('token'),
                localStorage.removeItem('name'),                
                this.auth = false
            ));
        },
       
        getContent (){
            if(this.token){
                localStorage.setItem('token', this.token);
                localStorage.setItem('name', this.username);
            }
            
            if(localStorage.getItem('token')) {
                this.username = '';
                this.password = '';
                this.name = localStorage.getItem('name');
                axios
                .post('/content', {token: localStorage.getItem('token')})
                .then(response => (
                    this.gridData = response.data.content
                ));
               this.auth = true;               
            }
        },
    },
    
    mounted: function(){
        this.getContent();
    }
});

Vue.component("log-grid", {
    template: "#grid-template",
    props: {
        logs: Array,
        columns: Array,
        filterKey: String
    },
    data: function() {
            var sortOrders = {};
            this.columns.forEach(function(key) {
            sortOrders[key] = 1;
        });
        return {
            sortKey: "",
            sortOrders: sortOrders
        };
    },
    computed: {
      filteredlogs: function() {
        var sortKey = this.sortKey;
        var filterKey = this.filterKey && this.filterKey.toLowerCase();
        var order = this.sortOrders[sortKey] || 1;
        var logs = this.logs;
        
        if(filterKey) {
          logs = logs.filter(function(row) {
            return Object.keys(row).some(function(key) {
                return (
                    String(row[key])
                      .toLowerCase()
                      .indexOf(filterKey) > -1
                );
            });
          });
        }
        
        if(sortKey) {
          logs = logs.slice().sort(function(a, b) {
            a = a[sortKey];
            b = b[sortKey];
            return (a === b ? 0 : a > b ? 1 : -1) * order;
          });
        }
        return logs;
      }
    },
    filters: {
        cap: function(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    },
    methods: {
        sortBy: function(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
        }
    }
});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import axios from 'axios';
//import VueAxios from 'vue-axios';
Vue.use(axios);

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('index-carousel', require('./components/indexCarousel.vue'));
Vue.component('tab-component', require('./components/tabComponent.vue'));
Vue.component('categorylist', require('./components/categorylist.vue'));
Vue.component('tab-component-text', require('./components/tabComponentText.vue'));
Vue.component('search-bar', require('./components/SearchBar.vue'));
Vue.component('paginator', require('./components/paginator.vue'));
Vue.component('image-mount', require('./components/imageMount.vue'));
Vue.component('upload', require('./components/uploadComponent.vue'));
Vue.component('modal', require('./components/modal.vue'));
Vue.component('new-series', require('./components/newSeriesComponent.vue'));
Vue.component('new-movies', require('./components/newMoviesComponent.vue'));
Vue.component('old-series', require('./components/updateSeriesComponent.vue'));
Vue.component('old-movies', require('./components/updateMoviesComponent.vue'));

Vue.directive('click-outside', {
    bind: function(el, binding, vnode){
        el.clickOutsideEvent = function(event){
            if(!(el == event.target || el.contains(event.target))){
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    }, 
    unbind: function(el){
        
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
   
});

const app = new Vue({
    el: '#app',
    created(){
    	
    }, 
    data(){
    	return{
    		name: 'Darlington'
    	}
    },
    methods:{
    	isEmpty(obj){
            let count = 0;
            let length = 0;
            for(var key in obj){
                length++;
                if(obj.key!=null){count++}
            }
            console.log('count is'+count);
            console.log('length is'+ length);
            return count==length? false : true;
            }
}
});

<template>
<div>
  <form class="form-inline my-2 my-lg-0 dropdown" id="search" v-on:submit.prevent="search()">
        <input class="form-control mr-sm-2" type="search" :placeholder="placeholder" v-model='searchQuery' v-on:keyup.enter='onEnter' aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0"  type="button" id="dropdownMenu1" :data-toggle="drop"
          aria-haspopup="true" aria-expanded="false" v-on:click="search">Search</button>
          <button></button>
         <div class="dropdown-menu w-100 bg-dark" style="white-space: normal; " aria-labelledby="dropdownMenu1">
		   <div v-if='hasresult'>	
			<a class="dropdown-item  bg-secondary text-white shadow" :href="results[key].link" v-for="(result, key) in results"> {{result.name}} </a>
		   </div>
		    <span class="dropdown-item-text text-danger " v-else-if='haserror'>{{error}}</span>
			<span class="dropdown-item-text text-primary  d-inline-block" style="word-wrap: break-word; max-width=100% " v-else> {{loadmessage}} </span>
         </div>
    
   </form>

</div>
</template>
<script>
	export default{
		props:{
			searchapi:{
				type: String,
				required: true
			}
		},
		data(){
			return{
				searchApi : this.searchapi + '?name=',
				searchQuery: '',
				placeholder: 'please enter a movie name to search',
				hasresult: false,
				results: {},
				error: '',
				haserror: false,
				loadmessage: 'Loading videos please wait...',
				searching: false,
				drop: ''
			}
		},
		methods:{
			getApi(queryApi){
			
    			axios.get(queryApi,
    		 			{headers:{ 'Content-Type':'application/json'}})
    			.then( function(response){ 
    		 				console.log(response.data);
    		 				console.log(response.data.error);
    		 				if(response.data.hasOwnProperty("error")){
    		 					console.log('first');
    		 					this.haserror = true;
    		 					this.error = response.data.error;
    		 					this.searchQuery= '';
    		 					this.searching = false;
    		 				}
    		 				if(response.data.hasOwnProperty(0)){
    		 					this.results = response.data;
    		 					this.hasresult = true;
    		 					this.searchQuery= '';
    		 					this.searching = false;
    		 				}
    		 			}.bind(this))
    			.catch(function(){
    				if(!this.hasresult && !this.haserror)
    				{
    				this.haserror = true;
    				this.error = 'There was a problem getting the video you wanted';
    				this.searchQuery= '';
    				this.searching = false;
    				}	
    			}.bind(this));
    		
    		}, 
    		onEnter(){
    			this.drop = 'dropdown';
    			if(!this.searching){
    				this.dropdown = 'dropdown';
    			}
    			//this.search();
    		},
    		search(){
    			this.drop = 'dropdown';
    			this.searching = true;
    			this.loadmessage = 'Loading video please wait...';
    			if(this.haserror || this.hasresult){
    				this.hasresult = false;
    				this.haserror = false;
    				this.error = '';
    				this.results = {};
    			}
    			else{
    				if(this.searchQuery.length> 2){
    					let queryAndApi = this.searchApi + this.searchQuery;
    					this.loadmessage = 'Loading video please wait...';
    					this.getApi(queryAndApi);
    				}
    				else{
    					this.loadmessage = 'Please type a name longer than two characters'
    				 }
    			}
    		}
    	}
		}
</script>
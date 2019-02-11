<template>
<div v-click-outside='dismissed' >
  <form class="form-inline my-2 my-lg-0 w-100 d-flex justify-content-center" id="search" v-on:submit.prevent="search()">
  	<div class="input-group clearfix">
        <input class="form-control" type="search" :placeholder="placeholder" v-model='searchQuery' v-on:keyup.enter='onEnter' aria-label="Search">
        <div class="input-group-prepend">
        <button class="btn btn-outline-success"  type="button" id="dropdownMenu1" 
          aria-haspopup="true" aria-expanded="false" v-on:click="search">Search</button>
      </div>
     </div>

          <div class="w-100 bg-light justify-content-center shadow border border-dark bg-dark"  :class="{'d-none': nodisplay, 'd-flex': clicked }">
           		<div class="shadow z-ind align-bottom shadow border border-dark matte " style="z-index: 1">
           			<ul v-if='hasresult' class="list-group no-pad search-parent w-searchresult">
           				<li class="list-group-item shadow border border-secondary dropdown-item no-pad search-item" v-for="(result, key) in results">
							<a class="matte dropdown-item-text text-white  shadow w-searchresult" :href="results[key].link" > {{result.name}} </a>
						</li>
		   			</ul>
		    		<span class="dropdown-item-text text-danger " v-else-if='haserror'>{{error}}</span>
					<span class="dropdown-item-text text-primary  d-inline-block" style="word-wrap: break-word; max-width=100% " v-else> {{loadmessage}} </span>
           		</div> 
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
				nodisplay: true,
				clicked: false

			}
		},
		watch:{
			clicked: function(val){
				return this.nodisplay = clicked ? false : true;
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
    		dismissed(){
    			let clickval = this.clicked;
    			this.clicked = clickval ? false : clickval;
    		},
    		onEnter(){
    			this.clicked = true;
    			this.search();
    		},
    		search(){
    			this.searching = true;
    			this.clicked = true;
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
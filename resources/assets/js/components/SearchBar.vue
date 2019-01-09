<template>
	<form class="form-inline my-2 my-lg-0" v-on:submit.prevent="getApi()">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0">Search</button>
    </form>
</template>
<script>
	export default{
		props:{

		},
		data(){
			return{

			}
		},
		methods:{
			/**getApi(){
    		axios.get('http://localhost/UdaraTV/api/mali',
    		 {headers:{ 'Content-Type':'application/json'}}).then( function(response){ console.log(response)});
    		}**/
    	}
		}
</script>
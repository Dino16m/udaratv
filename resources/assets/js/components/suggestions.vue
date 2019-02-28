<template>
	<div class="w-100" >
		<h2 class=" text-white text-capitalize p-2 d-block flex-row w-100 justify-content-between align-items-center text-center bg-secondary" v-if="hasContent">You may also like to watch these</h2><br>
		<div class="owl-carousel owl-theme" >
    		<div class="item" v-for="(video, key) in videos" style="height:200px">
    			<h3 class="h3-responsive text-capitalize align-items-center text-center" ><a  class="text-info  text-nowrap shadow text-center " v-bind:href="video.link">{{video.name}} </a></h3> 
        		<img class="d-block h-100" v-bind:src="video.image_link" v-bind:alt="video.name">
    		</div>
		</div>
	</div>
</template>
<script>
	export default{
		props:{
			api:{
				type: String,
				required: true,
			},
			name: {
				type: String,
				required: true
			},
			type:{
				type: String,
				required: true
			}
		},
		data(){
			return {
				Wapi : this.api + '?name='+this.name+'&type='+this.type,
				hasContent: false,
				placeholder: true,
				notplaceholder:false,
				show: false,
				videos: [{"name":"","link":"http:","image_link":"1"},
						 {"name":"","link":"http:","image_link":"2"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"placeholder3","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						 {"name":"","link":"http:","image_link":"3"},
						],
				videoss: [],


			}
		},
		methods:{
			getVideos(){
				let api = this.Wapi;
				axios.get(api,
    		 			{headers:{ 'Content-Type':'application/json'}})
    			.then( function(response){ 
    				if(response.status ===200 && response.data.hasOwnProperty(0))
    				{
    					//this.videos = this.vids;
    					this.videos = response.data;
    					this.hasContent = true;
    					this.placeholder = false;
    					this.notplaceholder = true;
    					console.log(response.data);
    				}
    			}
    			.bind(this))
    			.catch(function(){

    			}.bind(this))
			}
		},
		created(){
			
		},
		mounted(){
			this.getVideos();
		}
	}
</script>
<template>
	<form class="w-100 h-100">
             <input type="file" id="Files" name="Files" style="position: absolute; top: -500px;" ref="oldMoviesFiles" multiple v-on:change="handleFileUpload()">
              <div class="form-group">
    			<label for="oldMoviesName">Correct Name of Movie</label>
    			<input type="text" class="form-control" id="oldMoviesName" v-model='oldMoviesData.name' placeholder="please this has to be correct and mus match already existing name in db">
  			  </div>
  			  <div class="form-group">
    			<label for="oldMoviesType">Select the type of Movie this is</label>
    			<select class="custom-select" v-model='oldMoviesData.type' id="oldMoviesType">
    				<option value="nollywoodmovies"> NollyWood Movies</option>
    				<option value="hollywoodmovies"> HollyWood Movies</option>
    				<option value="bollywoodmovies"> BollyWood Movies</option>
    				<option value="animemovies"> Anime Movies</option>
    				<option value="asianmovies"> Asian Movies</option>
    			</select>
  			  </div>
  			  <div class="form-group">
    			<label for="oldMoviesQuality">Quality</label>
    			<select class="custom-select" v-model='oldMoviesData.quality' id="oldMoviesQuality">
    				<option value="HD"> HD</option>
    				<option value="MP4"> MP4</option>
    				<option value="3gp"> 3gp</option>
    				<option value="Avi"> Avi</option>
    			</select>
  			  </div>
  			  <div class="form-group">
  			 	<div class="custom-control custom-switch">
  					<input type="checkbox" v-model="oldMoviesData.haveLink" class="custom-control-input" id="customSwitch1">
 					 <label class="custom-control-label" for="customSwitch1">Do you have external link for this video</label>
				</div>
    			<label for="oldMoviesextLink" v-if='oldMoviesData.haveLink'>External Link</label>
    			<input type="text" class="form-control" id="oldMoviesextLink" v-if='oldMoviesData.haveLink' v-model='oldMoviesData.extLink' placeholder="default link">
    			<div class="custom-control custom-switch">
    			<input type="checkbox" v-model="oldMoviesData.shouldpull" v-if='oldMoviesData.haveLink' class="custom-control-input" id="customSwitch2">
 				<label class="custom-control-label" v-if='oldMoviesData.haveLink' for="customSwitch2">should we pull this links's content to our servers?</label>
 				</div>
  			 </div>
  			  <div class="custom-control custom-checkbox">
 				 <input type="checkbox" class="custom-control-input" v-model='oldMoviesData.should_show' id="customCheck1">
  				 <label class="custom-control-label" for="customCheck1">Should this update be triggered as new Update in HomePage?</label>
			   </div>
  			  <ul class="nav d-flex justify-content-center">
  			  	<li> <a class="nav-item flex-md-column  md-3 btn btn-danger" v-on:click="submit()"> upload </a> </li>
    		    <li><a class="nav-item flex-md-column  md-3 btn btn-primary" v-on:click="addfiles()">addVideo</a></li>
    		 </ul>
         	</form>
         	
            <!---->
</template>
<script>
	export default{
		data(){
			return{
				oldMoviesData: {quality:'', type:'', should_show:false, season_change:false, name:'', file:[], shouldpull: false, haveLink: false, extLink:'default'},
				allFiles:[],
			}
		},
		methods:{
			handleFileUpload(){
			 	let upload = this.$refs.oldMoviesFiles.files;
			 	let length= upload.length;
			 	for (var i = 0; i <length; i++) {
			 		this.allFiles.push(upload[i])
			 	}
			 	if(this.acceptedType('vids',upload[length-1].type)){
			 		this.oldMoviesData.file[0]=upload[length-1]; 
			 	}
			 	else{
			 		this.$emit('unsupportedVid' );
			 	}
			 	
			 
			},
			acceptedType(cat, type){
				let acceptedVids = ['mp4', '3gp', 'avi', 'mkv', '3gpp'];
				let acceptedpics =['jpeg', 'gif', 'png', 'jpg', 'bmp'];
				if(cat == 'vids'){
					for (var i = 0; i < acceptedVids.length; i++) {
						if(type.split('/').pop()==acceptedVids[i]){
							return true;
						}
					} return false;
				}
				if(cat == 'pics'){
					for (var i = 0; i < acceptedpics.length; i++) {
						if(type.split('/').pop()==acceptedpics[i]){
							return true;
						}
					} return false;
				}

			},
			addfiles(){
				 this.$refs.oldMoviesFiles.click() 
			},
			submit(){
				let Empty= {quality:'', type:'', should_show:false, season_change:false, name:'', shouldpull : false, haveLink: false, extLink:'default',file:[]};
				if(this.isEmpty(this.oldMoviesData)){
					this.$emit('emptyForm');
				}
				else{
					this.$emit('submitAttempt', this.oldMoviesData);
					this.oldMoviesData = Empty;
				}
			},
			isEmpty(obj){
				let count = 0;
				let length = 0;
				for(var key in obj){
					length++;
					if((obj[key]!=null && obj[key]!='') || obj[key]===false ){count++}
				}
			console.log('count is ' + count);
			console.log('length is ' + length);
			return count==length? false : true;
			}
	}
		}
</script>
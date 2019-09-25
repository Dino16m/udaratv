<template>
	<form class="w-100 h-100">
             <input type="file" id="Files" name="Files" style="position: absolute; top: -500px;" ref="newMoviesFiles" multiple v-on:change="handleFileUpload()">
             <input type="file" id="Images" name="Images" ref="newMoviesImages" style="position: absolute; top: -500px;" multiple v-on:change="handleImageUpload()">
              <div class="form-group">
    			<label for="newMoviesName">Correct Name of Movie</label>
    			<input type="text" class="form-control" id="newMoviesName" v-model='newMoviesData.name' placeholder="please this has to be correct">
  			  </div>
  			  <div class="form-group">
    			<label for="newMoviesdesc">Short Description of Movie</label>
    			<input type="text" class="form-control" id="newMoviesdesc" v-model='newMoviesData.desc' placeholder="short and concise yet entertaiming">
  			  </div>
  			  <div class="form-group">
    			<label for="newMoviesImdbLink">Imdb Link</label>
    			<input type="text" class="form-control" v-model='newMoviesData.imdbLink' id="newMoviesImdbLink" placeholder="you can find this link by going to Imdb.com">
  			  </div>
  			  <div class="form-group">
    			<label for="newMoviesType">Select the type of movie this is</label>
    			<select class="custom-select" v-model='newMoviesData.type' id="newMoviesType">
    				<option value="nollywoodmovies"> NollyWood Movie</option>
    				<option value="hollywoodmovies"> HollyWood Movie</option>
    				<option value="bollywoodmovies"> BollyWood Movie</option>
    				<option value="asianmovies"> Asian Movie</option>
    				<option value="animemovies"> Anime Movie</option>
    			</select>
  			  </div>
  			  <div class="form-group">
    			<label for="newMoviesImdbLink">Tags</label>
    			<input type="text" class="form-control" v-model='newMoviesData.tags' id="newMoviesTags" placeholder="Comedy, Action, Romance, Horror, Drama">
  			 </div>
  			  <div class="form-group">
    			<label for="newMoviesQuality">Quality</label>
    			<select class="custom-select" v-model='newMoviesData.quality' id="newMoviesQuality">
    				<option value="HD"> HD</option>
    				<option value="MP4"> MP4</option>
    				<option value="3gp"> 3gp</option>
    				<option value="Avi"> Avi</option>
    			</select>
  			  </div>
  			  <div class="form-group">
    			<label for="newMoviesRunTime">Run Time</label>
    			<input type="text" class="form-control" id="newMoviesRunTime" v-model='newMoviesData.runTime' placeholder="how long  is this movie? specify the unit of time">
  			 </div>
  			 
  			 <div class="form-group">
  			 	<div class="custom-control custom-switch">
  					<input type="checkbox" v-model="newMoviesData.haveLink" class="custom-control-input" id="customSwitch1">
 					 <label class="custom-control-label" for="customSwitch1">Do you have external link for this video</label>
				</div>
    			<label for="newMoviesextLink" v-if='newMoviesData.haveLink'>External Link</label>
    			<input type="text" class="form-control" id="newMoviesextLink" v-if='newMoviesData.haveLink' v-model='newMoviesData.extLink' placeholder="default link">
    			<div class="custom-control custom-switch">
    			<input type="checkbox" v-model="newMoviesData.shouldpull" v-if='newMoviesData.haveLink' class="custom-control-input" id="customSwitch2">
 				<label class="custom-control-label" v-if='newMoviesData.haveLink' for="customSwitch2">should we pull this links's content to our servers?</label>
 				</div> 
  			 </div>
			<div class="form-group">
				<div class="custom-control custom-switch">
					<input type="checkbox" v-model="newMoviesData.shouldnotify" class="custom-control-input" id="notifytelegram">
 					 <label class="custom-control-label" for="notifytelegram">Should we send to telegram?</label>
				</div>
				<div class='form-group' v-if='newMoviesData.shouldnotify'>
					<label for="trailerlink" >External Link</label>
					<input type="text" class="form-control" id="trailerlink" v-model='newMoviesData.trailerLink' placeholder="trailer link">
				</div>

			</div>
  			  <ul class="nav d-flex justify-content-center">
  			  	<li> <a class="nav-item flex-md-column  md-3 btn btn-danger" v-on:click="submit()"> upload </a> </li>
    		    <li><a class="nav-item flex-md-column  md-3 btn btn-primary" v-on:click="addfiles( 'video')">addVideo</a></li>
    		 	<li> <a class="nav-item flex-md-column  md-3 btn btn-secondary" v-on:click="addfiles('image')">addImage</a> </li>
    		 </ul>
         	</form>
         	
            <!---->
</template>
<script>
export default{
	data(){
		return{
		newMoviesData: {runTime:'', quality:'', tags:'', type:'', imdbLink:'', desc:'', name:'', file:[] ,image:[], haveLink: false, shouldpull: false, shouldnotify: false, trailerLink: '',
					 extLink:'default' },
		allFiles: [],
		allImages:[],
		}
	},
	methods:{
		handleFileUpload(){
			 	let upload = this.$refs.newMoviesFiles.files;
			 	let length= upload.length;
			 	for (var i = 0; i <length; i++) {
			 		this.allFiles.push(upload[i])
			 	}
			 	if(this.acceptedType('vids', upload[length-1].type)){
			 		this.newMoviesData.file[0]=upload[length-1]; 
			 	}
			 	else{
			 		this.$emit('unsupportedVid' );
			 	}
			 	
			 
			},
			handleImageUpload(){
				
				let upload = this.$refs.newMoviesImages.files;
				let length = upload.length;
				for (var i = 0; i <length; i++) {
			 		this.allImages.push(upload[i])
			 	}
			 	if(this.acceptedType('pics', upload[length-1].type)){
			 		this.newMoviesData.image.push(upload[length-1]); 
			 	}
			 	else{
			 		this.$emit('unsupportedPic' );
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
			addfiles(type){
				
					if(type=='image'){ this.$refs.newMoviesImages.click() }
					else{ this.$refs.newMoviesFiles.click() }
				
			},
			submit(){
				let Empty= {runTime:'', quality:'',tags:'', type:'',imdbLink:'',
				shouldnotify: false, trailerLink: '', shouldpull: false, desc:'', name:'', haveLink: false, extLink:'default' ,file:[],image:[] };
				if(this.isEmpty(this.newMoviesData)){
					this.$emit('emptyForm');
				}
				else{
					this.$emit('submitAttempt', this.newMoviesData);
					this.newMoviesData = Empty;
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
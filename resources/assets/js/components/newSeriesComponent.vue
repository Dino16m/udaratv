<template>
	<form class="w-100 h-100">
             <input type="file" id="Files" name="Files" style="position: absolute; top: -500px;" ref="newSeriesFiles" multiple v-on:change="handleFileUpload()">
             <input type="file" id="Images" name="Images" ref="newSeriesImages" style="position: absolute; top: -500px;" multiple v-on:change="handleImageUpload()">
              <div class="form-group">
    			<label for="newSeriesName">Correct Name of Series</label>
    			<input type="text" class="form-control" id="newSeriesName" v-model='newSeriesData.name' placeholder="please this has to be correct">
  			  </div>
  			  <div class="form-group">
    			<label for="newSeriesdesc">Short Description of Series</label>
    			<input type="text" class="form-control" id="newSeriesdesc" v-model='newSeriesData.desc' placeholder="short and concise yet entertaiming">
  			  </div>
  			  <div class="form-group">
    			<label for="newSeriesImdbLink">Imdb Link</label>
    			<input type="text" class="form-control" v-model='newSeriesData.imdbLink' id="newSeriesImdbLink" placeholder="you can find this link by going to Imdb.com">
  			  </div>
  			  <div class="form-group">
    			<label for="newSeriesType">Select the type of series this is</label>
    			<select class="custom-select" v-model='newSeriesData.type' id="newSeriesType">
    				<option value="nollywoodseries"> NollyWood Series</option>
    				<option value="hollywoodseries"> HollyWood Series</option>
    				<option value="bollywoodseries"> BollyWood Series</option>
    				<option value="asianseries"> Asian Series</option>
    				<option value="Animeseries"> Anime Series</option>
    			</select>
  			  </div>
  			  <div class="form-group">
    			<label for="newSeriesImdbLink">Tags</label>
    			<input type="text" class="form-control" v-model='newSeriesData.tags' id="newSeriesTags" placeholder="Comedy, Action, Romance">
  			 </div>
  			  <div class="form-group">
    			<label for="newSeriesQuality">Quality</label>
    			<select class="custom-select" v-model='newSeriesData.quality' id="newSeriesQuality">
    				<option value="HD"> HD</option>
    				<option value="MP4"> MP4</option>
    				<option value="3gp"> 3gp</option>
    				<option value="Avi"> Avi</option>
    			</select>
  			  </div>
  			  <div class="form-group">
    			<label for="newSeriesRunTime">Run Time</label>
    			<input type="text" class="form-control" id="newSeriesRunTime" v-model='newSeriesData.runTime' placeholder="how long does is a single episode of this series?">
  			 </div>
  			  <div class="form-group">
    			<label for="newSeriesSeasonNumber">Season Number</label>
    			<input type="text" class="form-control" id="newSeriesSeasonNumber" v-model='newSeriesData.seasonNumber' placeholder="what season is this?">
  			  </div>
  			  <div class="form-group">
    			<label for="newSeriesEpisodeNumber">Episode Number</label>
    			<input type="text" class="form-control" id="newSeriesEpisodeNumber" v-model="newSeriesData.episodeNumber" placeholder="Episode Number">
  			  </div>
  			  <div class="form-group">
  			 	<div class="custom-control custom-switch">
  					<input type="checkbox" v-model="newSeriesData.haveLink" class="custom-control-input" id="customSwitch1">
 					 <label class="custom-control-label" for="customSwitch1">Do you have external link for this video</label>
				</div>
    			<label for="newSeriesextLink" v-if='newSeriesData.haveLink'>External Link</label>
    			<input type="text" class="form-control" id="newSeriesextLink" v-if='newSeriesData.haveLink' v-model='newSeriesData.extLink' placeholder="default link">
    			<div class="custom-control custom-switch">
    			<input type="checkbox" v-model="newSeriesData.shouldpull" v-if='newSeriesData.haveLink' class="custom-control-input" id="customSwitch2">
 				<label class="custom-control-label" v-if='newSeriesData.haveLink' for="customSwitch2">should we pull this links's content to our servers?</label>
 				</div>
  			 </div>
			   <div class="form-group">
				<div class="custom-control custom-switch">
					<input type="checkbox" v-model="newSeriesData.shouldnotify" class="custom-control-input" id="notifytelegram">
 					 <label class="custom-control-label" for="notifytelegram">Should we send to telegram?</label>
				</div>
				<div class='form-group' v-if='newSeriesData.shouldnotify'>
					<label for="trailerlink" >External Link</label>
					<input type="text" class="form-control" id="trailerlink" v-model='newSeriesData.trailerLink' placeholder="trailer link">
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
		newSeriesData: {episodeNumber:'', seasonNumber: '', runTime:'', quality:'', tags:'',
				shouldnotify: false, trailerLink: '', shouldpull: false, type:'', imdbLink:'', desc:'', name:'', haveLink: false, extLink:'default', file:[] ,image:[] },
		newSeriesfiles:[ ],
		allFiles: [],
		allImages:[],
		}
	},
	methods:{
		handleFileUpload(){
			 	let upload = this.$refs.newSeriesFiles.files;
			 	let length= upload.length;
			 	for (var i = 0; i <length; i++) {
			 		this.allFiles.push(upload[i])
			 	}

			 	if(this.acceptedType('vids',upload[length-1].type)){
			 		this.newSeriesData.file[0]=upload[length-1]; 
			 	}
			 	else{
			 		this.$emit('unsupportedVid' );
			 	}
			 
			},
			handleImageUpload(){
				
				let upload = this.$refs.newSeriesImages.files;
				let length = upload.length;
				for (var i = 0; i <length; i++) {
			 		this.allImages.push(upload[i])
			 	}
			 	if(this.acceptedType('pics', upload[length-1].type)){
			 		this.newSeriesData.image.push(upload[length-1]); 
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
				
					if(type=='image'){ this.$refs.newSeriesImages.click() }
					else{ this.$refs.newSeriesFiles.click() }
				
			},
			submit(){
				let Empty = {episodeNumber:'', seasonNumber: '', runTime:'', quality:'',tags:'',
				shouldnotify: false, trailerLink: '', type:'',imdbLink:'',haveLink: false, extLink:'default', desc:'', name:'', file:[],image:[] , shouldpull: false};
					if(this.isEmpty(this.newSeriesData)){
						this.$emit('emptyForm');

					}
					else{
					this.$emit('submitAttempt', this.newSeriesData);
					this.newSeriesData = Empty;
					}
			},
			isEmpty(obj){
				let count = 0;
				let length = 0;
				for(var key in obj){
					length++;
					if((obj[key]!=null && obj[key]!='') || obj[key]===false ) {count++; console.log(key)}
				}
			console.log('count is'+count);
			console.log('length is'+ length);
			return count==length? false : true;
			}
	}
}
</script>
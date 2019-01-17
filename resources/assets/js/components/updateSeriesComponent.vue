<template>
	<form class="w-100 h-100">
             <input type="file" id="Files" name="Files" style="position: absolute; top: -500px;" ref="oldSeriesFiles" multiple v-on:change="handleFileUpload()">
              <div class="form-group">
    			<label for="oldSeriesName">Correct Name of Series</label>
    			<input type="text" class="form-control" id="oldSeriesName" v-model='oldSeriesData.name' placeholder="please this has to be correct">
  			  </div>
  			  <div class="form-group">
    			<label for="oldSeriesType">Select the type of series this is</label>
    			<select class="custom-select" v-model='oldSeriesData.type' id="oldSeriesType">
    				<option value="nollywoodseries"> NollyWood Series</option>
    				<option value="hollywoodseries"> HollyWood Series</option>
    				<option value="bollywoodseries"> BollyWood Series</option>
    			</select>
  			  </div>
  			  <div class="form-group">
    			<label for="oldSeriesQuality">Quality</label>
    			<select class="custom-select" v-model='oldSeriesData.quality' id="oldSeriesQuality">
    				<option value="HD"> HD</option>
    				<option value="MP4"> MP4</option>
    				<option value="3gp"> 3gp</option>
    				<option value="Avi"> Avi</option>
    			</select>
  			  </div>
  			  <div class="custom-control custom-checkbox">
 				 <input type="checkbox" class="custom-control-input" v-model='oldSeriesData.should_show' id="customCheck1">
  				 <label class="custom-control-label" for="customCheck1">Should this update be triggered as new Update in HomePage?</label>
			   </div>
			   <div class="custom-control custom-checkbox">
 				 <input type="checkbox" class="custom-control-input" v-model='oldSeriesData.season_change' id="customCheck2">
  				 <label class="custom-control-label" for="customCheck2">is this the first episode of a new season?</label>
			   </div>
  			  <div class="form-group">
    			<label for="oldSeriesSeasonNumber">Season Number</label>
    			<input type="text" class="form-control" id="oldSeriesSeasonNumber" v-model='oldSeriesData.seasonNumber' placeholder="what season is this?">
  			  </div>
  			  <div class="form-group">
    			<label for="oldSeriesEpisodeNumber">Episode Number</label>
    			<input type="text" class="form-control" id="oldSeriesEpisodeNumber" v-model="oldSeriesData.episodeNumber" placeholder="Episode Number">
  			  </div>
  			   <div class="form-group">
  			 	<div class="custom-control custom-switch">
  					<input type="checkbox" v-model="oldSeriesData.haveLink" class="custom-control-input" id="customSwitch1">
 					 <label class="custom-control-label" for="customSwitch1">Do you have external link for this video</label>
				</div>
    			<label for="oldSeriesextLink" v-if='oldSeriesData.haveLink'>External Link</label>
    			<input type="text" class="form-control" id="oldSeriesextLink" v-if='oldSeriesData.haveLink' v-model='oldSeriesData.extLink' placeholder="default link">
  			 </div>
  			  <ul class="nav d-flex justify-content-center">
  			  	<li> <a class="nav-item flex-md-column  md-3 btn btn-danger" v-on:click="submit()"> upload </a> </li>
    		    <li><a class="nav-item flex-md-column  md-3 btn btn-primary" v-on:click="addfiles()">addVideo</a></li>
    		 </ul>
         	</form>
         	
            <!---->
</template>
<script >
	export default{
		data(){
			return{
				oldSeriesData: {episodeNumber:'', seasonNumber: '',  quality:'', type:'', should_show:false, season_change:false, haveLink: false, extLink:'default', name:'', file:[] },
				allFiles:[],
			}
		},
		methods:{
			handleFileUpload(){
			 	let upload = this.$refs.oldSeriesFiles.files;
			 	let length= upload.length;
			 	for (var i = 0; i <length; i++) {
			 		this.allFiles.push(upload[i])
			 	}
			 	if(this.acceptedType('vids',upload[length-1].type)){
			 		this.oldSeriesData.file[0]=upload[length-1];  
			 	}
			 	else{
			 		this.$emit('unsupportedVid' );
			 	}
			 	
			 
			},
			acceptedType(cat, type){
				let acceptedVids = ['mp4', '3gp', 'avi', 'mkv', '3gp'];
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
				 this.$refs.oldSeriesFiles.click() 
			},
			submit(){
				let Empty = {episodeNumber:'', seasonNumber: '',  quality:'', type:'', should_show:false,haveLink: false, extLink:'default', season_change:false, name:'', file:[]};
				if(this.isEmpty(this.oldSeriesData)){
					this.$emit('emptyForm');
				}
				else{
					this.$emit('submitAttempt', this.oldSeriesData);
					this.oldSeriesData = Empty;
				}
			},
			isEmpty(obj){
				let count = 0;
				let length = 0;
				for(var key in obj){
					length++;
					if((obj[key]!=null && obj[key]!='') || obj[key]===false ){count++; console.log(key)}
				}
			console.log('count is ' + count);
			console.log('length is ' + length);
			return count==length? false : true;
			}
	}
		}
</script>
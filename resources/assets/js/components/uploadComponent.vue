<template>
	<div>
	 <!--nav-bar-start-->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top justify-content-between">
        <a class="navbar-brand" href="#"><img :src="imgSrc" alt="udaratv" height="40px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" v-on:click='active("newseries")' >Add New Series <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" v-on:click='active("oldseries")' >Update Existing Series</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" v-on:click='active("newmovies")' >Add new Movie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" v-on:click='active("oldmovies")'>Update Existing Movie</a>
                </li> 
                <li class="nav-item">
                    <button class="nav-link btn btn-success" v-on:click='upload()'>Submit to server</button>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" :href="regUrl">Add another user</a>
                </li>
                
            </ul>
           <search-bar :searchapi="searchApi"></search-bar>
        </div>
    </nav>
<!--nav-bar-end-->
 <div>

<modal ref='child' :msg='modal_msg'> </modal>

<div class="d-flex w-100 h-100">
	<div class="row  flex-fill">
        <div class="d-flex flex-row mx-auto mb-3 h-100 w-75">
            <div class="col-md-8 border border-primary w-100 flex-fill">
           		<h3>New Series</h3>
           		 <div class="progress bg-success" v-if='nsStatus.started'>
           		<div class="progress-bar progress-bar-striped text-center"  role="progressbar" v-bind:style="{width: nsStatus.width}" 		v-bind:aria-valuenow="nsStatus.uploadValue" aria-valuemin="0" aria-valuemax="100"> {{nsStatus.width}}
           		</div>
           		</div>
           		<div class="alert alert-success mt-sm-2 d-inline-block bg-info w-100" v-if='nsStatus.success' role="alert"> {{nsStatus.msg}} <button class="btn btn-secondary" v-on:click="clear('ns')"> </button></div>

            <div class="alert alert-success mt-sm-2 d-inline-block bg-primary w-100" role="alert" v-for='(value, key) in newSeriesfiles'>
   				 <strong>{{value.name}}-season{{value.seasonNumber}}-episode{{value.episodeNumber}}- {{value.quality}} quality</strong>  type: {{value.type}} actual filename: {{value.file[0].name}}
		    	 <button class="btn btn-danger" v-on:click="remove( 'key', 'newseries')">remove</button>
		    	
       				 
			</div><hr>
			<h3>Old Series</h3>
			<div class="progress bg-success" v-if='osStatus.started'>
           		<div class="progress-bar progress-bar-striped text-center"  role="progressbar" v-bind:style="{width: osStatus.width}" 		v-bind:aria-valuenow="osStatus.uploadValue" aria-valuemin="0" aria-valuemax="100"> {{osStatus.width}}
           		</div>
           		</div>
           		<div class="alert alert-success mt-sm-2 d-inline-block bg-info w-100" v-if='osStatus.success' role="alert"> {{osStatus.msg}} <button class="btn btn-secondary" v-on:click="clear('os')"> </button></div>
            <div class="alert alert-success mt-sm-2 d-inline-block bg-primary w-100" role="alert" v-for='(value, key) in oldSeriesfiles'>
   				 <strong>{{value.name}}-season{{value.seasonNumber}}-episode{{value.episodeNumber}}- {{value.quality}} quality</strong> type: {{value.type}}  actual filename: {{value.file[0].name}}
		    	 <button class="btn btn-danger" v-on:click="remove( 'key', 'oldseries')">remove</button> 
			</div><hr>

			<h3>New movies</h3>
			<div class="progress bg-success" v-if='nmStatus.started'>
           		<div class="progress-bar progress-bar-striped text-center"  role="progressbar" v-bind:style="{width: nmStatus.width}" 		v-bind:aria-valuenow="nmStatus.uploadValue" aria-valuemin="0" aria-valuemax="100"> {{nmStatus.width}}
           		</div>
           		</div>
           		<div class="alert alert-success mt-sm-2 d-inline-block bg-info w-100" v-if='nmStatus.success' role="alert"> {{nmStatus.msg}} <button class="btn btn-secondary" v-on:click="clear('nm')">OK</button></div>
            <div class="alert alert-success mt-sm-2 d-inline-block bg-primary w-100" role="alert" v-for='(value, key) in newMoviesfiles'>
   				 <strong>{{value.name}}-{{value.quality}} quality</strong> type: {{value.type}} actual filename: {{value.file[0].name}}
		    	 <button class="btn btn-danger" v-on:click="remove( 'key', 'newmovies')">remove</button> 
			</div><hr>

			<h3>Old Movies</h3>
			<div class="progress bg-success" v-if='omStatus.started'>
           		<div class="progress-bar progress-bar-striped text-center"  role="progressbar" v-bind:style="{width: omStatus.width}" 		v-bind:aria-valuenow="omStatus.uploadValue" aria-valuemin="0" aria-valuemax="100"> {{omStatus.width}}
           		</div>
           		</div>
           		<div class="alert alert-success mt-sm-2 d-inline-block bg-info w-100" v-if='omStatus.success' role="alert"> {{omStatus.msg}} <button class="btn btn-secondary" v-on:click="clear('om')"> </button></div>
            <div class="alert alert-success mt-sm-2 d-inline-block bg-primary w-100" role="alert" v-for='(value, key) in oldMoviesfiles'>
   				 <strong>{{value.name}}- {{value.quality}} quality</strong> type: {{value.type}} actual filename: {{value.file[0].name}}
		    	 <button class="btn btn-danger" v-on:click="remove( 'key', 'oldmovies')">remove</button> 
			</div><hr>

            </div>
            <div class="col-md-8 border border-secondary w-100 flex-fill">
            <!--New Series Form-->
            <new-series v-on:emptyForm='clickModal' v-on:unsupportedPic=" clickModal('unsupported picture format')" v-on:unsupportedVid="clickModal('unsupported video format')" v-on:submitAttempt='submit("newseries", $event)' v-if='isFocus("newseries")'> </new-series>
            <new-movies v-on:emptyForm='clickModal'  v-on:unsupportedPic=" clickModal('unsupported picture format')" v-on:unsupportedVid="clickModal('unsupported video format')" v-on:submitAttempt='submit("newmovies", $event)' v-if='isFocus("newmovies")'> </new-movies>
            <old-series v-on:emptyForm='clickModal' v-on:unsupportedVid="clickModal('unsupported video format')" v-on:submitAttempt='submit("oldseries", $event)' v-if='isFocus("oldseries")'> </old-series>
            <old-movies v-on:emptyForm='clickModal' v-on:unsupportedVid="clickModal('unsupported video format')" v-on:submitAttempt='submit("oldmovies", $event)' v-if='isFocus("oldmovies")'> </old-movies>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</template>
<script>
	export default{
		props:{
			imageurl:{
				type: String,
				required: true
			},
			register:{
				type: String
			},
			oldmovies:{
				type:String,
				required:true
			},
			oldseries:{
				type:String,
				required: true
			},
			newmovies:{
				type: String,
				required: true
			},
			newseries:{
				type:String,
				required: true
			},
			searchapi:{
				type: String
			}
		},
		data(){
			return{
				regUrl: this.register,
				searchApi: this.searchapi,
				oldmoviesAPI: this.oldmovies,
				oldseriesAPI: this.oldseries,
				newmoviesAPI: this.newmovies,
				newseriesAPI: this.newseries,
				imgSrc: this.imageurl,
				newSeriesfiles:[],
				newMoviesfiles:[],
				oldSeriesfiles:[],
				oldMoviesfiles:[], 
				allFiles: [],
				allImages:[],
				modal_msg: "you can't submit an Empty form",
				clickChange: '',
				isActive: 'newseries', 
				nsStatus:{width:'1%', uploadValue:0, started: false, success:false, msg: ''},
				nmStatus:{width:'1%', uploadValue:0, started: false, success:false, msg: ''},
				osStatus:{width:'1%', uploadValue:0, started: false, success:false, msg: ''},
				omStatus:{width:'1%', uploadValue:0, started: false, success:false, msg: ''},

			}
		},
		mounted(){
			this.isActive = 'newseries'
		},
		methods:{
			
			submit(type, data){
				
				if(type=='newseries'){
					this.newSeriesfiles.push(data);

				}
				else if(type=='newmovies'){
					this.newMoviesfiles.push(data)
				}
				else if(type=='oldseries'){
					this.oldSeriesfiles.push(data)
				}
				else if(type=='oldmovies'){
					this.oldMoviesfiles.push(data)
				}
				else{}
				
			},
			clear(type){
				let empty = {width:'1%', uploadValue:0, started: false, success:false, msg: ''};
				switch(type){
					case 'ns':
						this.nsStatus=empty;
						break;
					case 'os':
						this.osStatus=empty;;
						break;
					case 'nm':
						this.nmStatus=empty;
						break;
					case 'om':
						this.omStatus=empty;
						break;
					default:

				}
			},
			upload(){
				if(this.emptyPayload()){
					this.clickModal();
				}
				this.uploadNew();
			},
			emptyPayload(){
				let count = 0;
				if(this.newMoviesfiles.length==0){ count++ }
				if(this.oldMoviesfiles.length==0){ count++ }
				if(this.newSeriesfiles.length==0){ count++ }
				if(this.oldSeriesfiles.length==0){ count++ }
					console.log('count is '+ count);
					return count==4 ? true :false;
			},
			clickModal(msg=null){
				if (msg) {
					this.modal_msg= msg;
				} else {
					this.modal_msg = "you can't submit an Empty form";
				}
				this.$refs.child.clicked();
			}, 
			active(type){
				this.isActive=type;
			},
			isFocus(type){
				return this.isActive==type? true : false;
			},
			remove(key, where){
				switch(where){
					case 'newseries':
						this.newSeriesfiles.splice(key, 1);
						break;
					case 'oldseries':
						this.oldSeriesfiles.splice(key, 1);
						break;
					case 'newmovies':
						this.newMoviesfiles.splice(key, 1);
						break;
					case 'oldmovies':
						this.oldMoviesfiles.splice(key, 1);
						break;
					default:

				}
			},
			uploaded(type){
				switch(type){
					case 'newseries':
						this.newSeriesfiles=[];
						break;
					case 'oldseries':
						this.oldSeriesfiles =[];
						break;
					case 'newmovies':
						this.newMoviesfiles=[];
						break;
					case 'oldmovies':
						this.oldMoviesfiles=[];
						break;
					default:

				}
			},
			uploadNew(){
				if(this.newSeriesfiles.length != 0){
					let payload =this.newSeriesfiles;
					let hook = this.nsStatus;
					let api = this.newseriesAPI;
					this.prepUpload(payload, 'newseries', hook, api);		
				}
				if(this.newMoviesfiles.length!=0){
					let payload = this.newMoviesfiles;
					let hook = this.nmStatus;
					let api = this.newmoviesAPI;
					this.prepUpload(payload, 'newmovies', hook, api);
				}
				if(this.oldSeriesfiles.length!=0){
					let payload = this.oldSeriesfiles;
					let hook = this.osStatus;
					let api = this.oldseriesAPI;
					this.prepUpload(payload, 'oldseries', hook, api);
				}
				if(this.oldMoviesfiles.length!=0){
					let payload = this.oldMoviesfiles;
					let hook = this.omStatus;
					let api = this.oldmoviesAPI;
					this.prepUpload(payload, 'oldseries', hook, api);
				}
			},
			prepUpload(payload, type, hook, api){
				let formData = new FormData();
				for (var i = 0; i < payload.length; i++) {
						let it=payload[i];
						let name = this.pad(i)+payload[i].name;
						let file = this.createFile(payload[i].file[0], name);
						if (!file){this.clickModal('there is a problem parsing your file ' + name); break;}
						let json =this.getJson(type, it);
						formData.append('files['+i+']', file);
						if(type=='newseries'|| type =='newmovies'){
							formData.append('image'+this.pad(i), it.image[0]);
						}	
						formData.append('data'+this.pad(i), JSON.stringify(json));
						this.apiCall(formData, hook, api, type);
						
					}
			},
			getJson(type, it){
				switch(type){
					case 'newseries':
						return {quality:it.quality, type: it.type, runTime: it.runTime, seasonNumber: it.seasonNumber, episodeNumber: it.episodeNumber, desc: it.desc, imdbLink: it.imdbLink, shouldpull:it.shouldpull, haveLink:it.haveLink, extLink:it.extLink, tags:JSON.stringify(it.tags.split(',')) };
						break;
					case 'oldseries':
						return {episodeNumber:it.episodeNumber, seasonNumber: it.seasonNumber,haveLink:it.haveLink, extLink:it.extLink,  quality:it.quality, type:it.type, shouldShow:it.should_show,  shouldpull:it.shouldpull, seasonChanged:it.season_change};
						break;
					case 'newmovies':
						return {runTime:it.runTime, quality:it.quality, haveLink:it.haveLink,  shouldpull:it.shouldpull, extLink:it.extLink, tags:JSON.stringify(it.tags.split(',')), type:it.type, imdbLink:it.imdbLink, desc:it.desc};
						break;
					case 'oldmovies':
						return {quality:it.quality, type:it.type, haveLink:it.haveLink,  shouldpull:it.shouldpull, extLink:it.extLink, shouldShow:it.should_show, seasonChange:it.season_change };
						break;
					default:
				}
			},
			apiCall(formData, hook, api, type){
				hook.started=true;
				axios.post(api, formData, {headers:{ 'Content-Type': 'multipart/form-data'},
							onUploadProgress: function(progressEvent){
                  			hook.uploadValue = parseInt(Math.round((progressEvent.loaded*100)/progressEvent.total));
                  			let value=hook.uploadValue;
                  			console.log(value+'me');
                  			hook.width= (value.toString()+'%');
                			}.bind(this) })
							.then(function(response) {
							 console.log(response);
							 hook.success=true;
							 hook.msg= response.data;
							 this.uploaded(type);
							}.bind(this))
							.catch(function(){
             						 hook.msg = 'unfortunately not uploaded';
             						}.bind(this));
			},
			pad(number){
				let final = number.toString();
				if(final.length == 3){
					return final;
				}
				let zerolen= 3 - final.length;
				for (var i = 0; i < zerolen; i++) {
						final = '0'+final;
				}
				return final

			},
			createFile(file, name){
				let ext = file.name.split('.').pop();
				let blob = file.slice(0, file.size, file.type );
				let newFile = new File([blob], name+'.'+ext, {type: file.type});
				return newFile == null ? false: newFile;
			}

		}
	}
</script>
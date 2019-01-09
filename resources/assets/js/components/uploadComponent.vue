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
                    <a class="nav-link" href="">Add New Series <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Update Existing Series</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Add new Movie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Update Existing Movie</a>
                </li>  
            </ul>
           <search-bar></search-bar>
        </div>
    </nav>
<!--nav-bar-end-->
 <div>

<modal ref='child' :msg='modal_msg'> </modal>

<div class="d-flex w-100 h-100">
	<div class="row  flex-fill">
        <div class="d-flex flex-row mx-auto mb-3 h-100 w-75">
            <div class="col-md-8 border border-primary w-100 flex-fill">
            
            </div>
            <div class="col-md-8 border border-secondary w-100 flex-fill">
            <!--New Series Form-->
            <new-series> </new-series>
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
				type: String
			}
		},
		data(){
			return{
				imgSrc: this.imageurl,
				newSeriesData: {episodeNumber:'', seasonNumber: '', runTime:'', quality:'',tags:'', type:'',imdbLink:'',desc:'',name:'', file:[] ,image:[] },
				EmptynewSeriesData: {episodeNumber:'', seasonNumber: '', runTime:'', quality:'',tags:'', type:'',imdbLink:'',desc:'',name:'', file:[] ,image:[] },
				newSeriesfiles:[ ],
				newMovies:[],
				oldSeries:[],
				oldMovies:[], 
				allFiles: [],
				allImages:[],
				modal_msg: '',
				clickChange: ''
			}
		},
		methods:{
			handleFileUpload(type){
			 if(type=='newseries'){
			 	let upload = this.$refs.newSeriesFiles.files;
			 	let length= upload.length;
			 	for (var i = 0; i <length; i++) {
			 		this.allFiles.push(upload[i])
			 	}
			 	this.newSeriesData.file.push(upload[length-1]); 
			 }
			},
			handleImageUpload(type){
				if(type=='newseries'){
				let upload = this.$refs.newSeriesImages.files;
				let length = upload.length;
				for (var i = 0; i <length; i++) {
			 		this.allImages.push(upload[i])
			 	}
			 	this.newSeriesData.image.push(upload[length-1]); 
			 }
			},
			addfiles(type, where){
				if(where=='newSeries'){
					if(type=='image'){ this.$refs.newSeriesImages.click() }
					else{ this.$refs.newSeriesFiles.click() }
				}
			},
			submit(type){
				
				if(type=='newseries'){
					if(this.isEmpty(this.newSeriesData)){
						//this.clickModal("You can't upload an empty form");
					}
					this.newSeriesfiles.push(this.newSeriesData);
					this.newSeriesData = this.EmptynewSeriesData;

				}
				
			},
			isEmpty(obj){
				let count = 0;
				for(var key in obj){
					if(obj.hasOwnProperty(key)){count++}
				}
			return count==obj.length? false : true;
			},
			clickModal(msg){
				this.modal_msg = msg;
				this.$refs.child.clicked();
			}

		}
	}
</script>
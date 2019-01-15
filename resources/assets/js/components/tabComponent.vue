<template>

 <!-- Nav tabs -->
<div class="col-lg-3 col-md-4 col-xs-6">
  <div class="poster-item h-50">
      <a v-bind:href="thevideourl" class="d-block mb-4 h-100">
     	 <img class="img-fluid " v-bind:src="theimageurl" v-bind:alt="thename">
      </a>
  </div>
</div>

</template>
<script>
	export default{
		props:{
			imageurl: String,
			videourl: String,
			name:     String

		},
		data(){
			return{
			thename:     this.name,
			thevideourl: this.videourl,
			theimageurl: this.imageurl,
			}
			
		}
	}
</script> 
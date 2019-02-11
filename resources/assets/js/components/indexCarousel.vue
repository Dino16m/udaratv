<template>
<div class="owl-carousel owl-theme">
    <div class="item" v-for="(video, key) in videos" style="height:260px">
        <img class="d-block h-100" v-bind:src="video.imageurl" v-bind:alt="video.name">
             <h3 class="h3-responsive text-uppercase"><a class="name text-primary" v-bind:href="video.url">{{video.name}} </a></h3> 
    </div>
</div>





</template>
<script>    
export default{
props:{
	videodetails: Array
},
data(){
	return{
		videos: this.videodetails,
        nottest: false
	}
},
methods:{
	active(isCarousel, key){
		let thiskey = key;
		let bool = isCarousel;
		if(!bool){
			return thiskey==0 || thiskey =='0' ? 'active': '';
				}
		return thiskey==0 || thiskey=='0' ? 'carousel-item active' : 'carousel-item'

	}
}

}
</script>
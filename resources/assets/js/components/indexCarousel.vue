<template>

	<!--Carousel Wrapper-->
    <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">

        <!--Indicators-->
        <ol class="carousel-indicators" >
            <li data-target="#carousel-example-2" v-for="(video, key) in videos" v-bind:class='active(false, key)' v-bind:data-slide-to="key" ></li>
        </ol>
        <!--/.Indicators-->
        <!--Slides-->
          <div class="carousel-inner" role="listbox">
            <div v-bind:class="active(true, key)" v-for='(video, key) in videos'>
                <div class="view">
                    <img class="d-block w-100 img-fluid" v-bind:src="video.imageurl" v-bind:alt="video.name">
                    <div class="mask rgba-black-light"></div>
                </div>
                <div class="carousel-caption">
                    <h3 class="h3-responsive"><a v-bind:href="video.url">{{video.name}} </a></h3>
                </div>
            </div>
   		   </div>
   	    <!--/.Slides-->
   	     <!--Controls-->
        <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <!--/.Controls-->

    </div>
    <!--/.Carousel Wrapper-->
    <!--carousel end-->
</template>
<script>
export default{
props:{
	videodetails: Array
},
data(){
	return{
		videos: this.videodetails
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
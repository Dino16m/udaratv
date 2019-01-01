<template>
	<section>
	 <main role="main" class="container" >
        <div class="starter-template">
            <h2 class="headit">Recently updated</h2>
            <hr class="">

            <br>

            <div class="container-fluid" >

                <br>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active bg-dark" v-for='(category, key) in categories' data-toggle="tab" v-bind:href="getCat(category)">{{category}}</a>
                    </li>
                    <li class="nav-item">

                    </li>
                </ul>
                <!-- Tab panes -->
                <p v-for="(sortedserie, key) in sortedseries">{{key}}</p>
                <div class="tab-content">
                    <div v-for='(category, key) in categories' v-bind:id="category" v-bind:class="getClass(key)"><br>
                        <div class="container">

                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center">Download latest {{category}}.</p>
                            </h1>
                            <br>
                            <div class="row text-center text-lg-left" v-if="catIn(category, series)">
                            		<p> homeboys {{sortedvideos[0]}}</p>

                            	<tabComponent > </tabComponent>
                            </div>
                            <div class="row text-center text-lg-left" v-else>
                            	<tabComponent v-for='(cat, key) in sortedvideos['1']' v-bind:imageurl='cat.imageurl' v-bind:name='cat.name' v-bind:videourl='cat.videourl'> </tabComponent>
                            </div>
                        	</div>
                    	</div>
               	 	</div>
            	</div>
        </div>
    </div>
</main>
  </section>
            

</template>
<script>
	import tabComponent from './tabComponent.vue';
	export default{
		components:{
			tabComponent: tabComponent
		},
		props:{
			thiscategories:{
				type: Array,
				required: true
			},
			thisvideodetails: {
				type: Array,
				required: true
			}
		},
		data(){
			return{
			categories: this.thiscategories,
			videodetails: this.thisvideodetails,
			sortedvideos: [],
			series: ['naijaseries', 'series', 'hollywoodseries'],
			movies: ['naija', 'hollywood', 'comedy', 'bollywood']
		}
		},
		created(){
			this.sortCategories()
		},
		methods:{
			getClass(key){
				//return (key == 0 || key=='0')? 'container tab-pane active' : 'container tab-pane fade'
				return 'container tab-pane active';
			},
			getCat(category){
				let cat = category;
				return '#' + cat;
			},
			sortCategories(){
				this.sortedvideos[0] = [];
				this.sortedvideos[1] = [];
				for (var i = this.videodetails.length - 1; i >= 0; i--) {
					let now = this.videodetails[i];
					if(now.season != '' && this.notIn(this.sortedseries, now.name)){
						this.sortedseries.push(now);
					}
					if(now.season == '' && this.notIn(this.sortedvideos[1], now.name)){
						this.sortedvideos[1].push(now);
					}
					console.log(this.sortedvideos)
					
				}
			},
			notIn(array, name){
				let workingArray = array;
				let workingName = name;
				if (workingArray==[]){ return true;}
				for (var i = workingArray.length - 1; i >= 0; i--) {
					let thisName=workingArray[i].name;
					if (thisName==workingName) {return false;}
				}
				return true;
			},
			catIn(value, array){
				for (var i = 0; i < array.length; i++) {
					if(array[i]==value){
						return true;
					}

				}
				return false;
			}
			

		}
	}
</script>
<template>
	<div>
		<meta name="og:image" property="og:image" content="image_url">
		 <div class=" img pt-4 mt-4">
           <div class=" img pt-4 mt-4">
            <img :src="image_url"  class="img-fluid w-50 h-50 border rounded border-light" :alt="alt">
         </div>
         <br>
         <h3 class="text-center">{{Name}}</h3>
         <br>

         <div class="card" v-if="seasonAndEps()">
         	<p class="field"> Season: {{Season}} </p>
         	<p class="field">Episode: {{Episode}} </p>
	   </div>

        <div class="card" v-if="needed">
         	<p class="field">Number of Seasons: {{v_number_of_seasons}} </p>
         	<p class="field" v-if='episodes()'>Number of Episodes: {{v_number_of_episodes}} </p>
         	<p class="field">Number of Views: {{v_views}} </p>
	   </div>

            <div class="container w-100" v-if='isHome'>
                <div class="row h-100 w-100 desc-lg">
                    <div class="d-flex flex-row mx-auto mb-3">
                        <div class="col-sm-6 text-right description ">
                            <p>
                                {{desc}}
                            </p>
                            <br>
                            
                        </div>

                        <div class=" col-sm-6 text-left text-nowrap">
                            <p class="field">Genres: <span v-html="Genre"></span></p>
                            <p class="field"> <strong class="text-danger">IMDB:</strong><a :href="v_imdb_link">{{v_imdb_link}}</a> </p>
                            <p class="field">Casts: <p> </p></p>
                            <p class="field">Run Time: {{v_run_time}}</p>
                            <p class="field">views:{{v_views}}</p>
                            <p class="field" v-if="v_is_series">seasons:<span>{{number_of_seasons}}</span></p>
                        </div>
                    </div>
                </div>

                <div class="col w-100 desc-mobile">
                	<div class="d-flex flex-column mx-auto mb-3">
                		<hr class="light w-100">
                		 <div class=" p-2 text-center text-nowrap">
                            <p class="field">Genres: <span v-html="Genre"></span></p>
                            <p class="field"> <strong class="text-danger">IMDB:</strong><a :href="v_imdb_link">{{v_imdb_link}}</a> </p>
                            <p class="field">Casts: <p> </p></p>
                            <p class="field">Run Time: {{v_run_time}}</p>
                            <p class="field">views:{{v_views}}</p>
                            <p class="field" v-if="v_is_series">seasons:<span>{{number_of_seasons}}</span></p>
                        </div>

            			<hr class="underline w-100">
          
                		<div class="p-2 text-justify  ">
                            <p>
                                {{desc}}
                            </p>
                            <br>
                            
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
			name:{
				type: String,
				required: true
			},
			image_link:{
				type:String
			},
			views:{
				type: String
			},
			reuse:{
				type: Boolean
			},
			ishome:{
				type: Boolean
			},
			id:{
				type: String
			},
			number_of_seasons:{
				type: String
			},
			imdb_link:{
				type: String
			},
			desc:{
				type: String
			},
			run_time:{
				type: String
			},
			number_of_episodes:{
				type: String
			},
			isseries:{
				type: Boolean
			},
			base_url:{
				type: String
			},
			episode:{
				type:String
			},
			season:{
				type:String
			},
			tags:{
				required: true,
				type: String
			}
		},
		data(){
			return{
				Name: this.name.toUpperCase(),
				alt : this.name + " | Watch Movies Online",
				image_url: this.image_link,
				needed: this.reuse,
				v_views: this.views,
				v_id: this.id,
				v_number_of_seasons: this.number_of_seasons,
				v_imdb_link: this.imdb_link,
				v_desc: this.desc,
				v_run_time: this.run_time,
				v_number_of_episodes: this.number_of_episodes,
				v_is_series: this.isseries,
				url: this.base_url,
				tagUrl : this.base_url + '/tags/',
				Season: this.season,
				Episode: this.episode,
				isHome: this.ishome,
				Genre: ''
			}
		},
		methods:{
			saveData(){
				let ArrToStore={alt: this.alt, image_url: this.image_url, v_id: this.v_id, views:this.v_views, v_number_of_seasons: this.v_number_of_seasons};
				let storageKey = this.name;
				let json = JSON.stringify(ArrToStore);
				localStorage.setItem(storageKey, json);
			},
			makeGenre(){
				if(this.tags === 'none'){
					return '';
				}
				let tags = JSON.parse(this.tags);
				let genre= '';
				for (var i = 0; i < tags.length; i++) {
					let tag = tags[i];
						let comma = tags.length-1 == i ? '':',';
						genre += this.makeHref(tag.tag)+comma;
				}
				
				this.Genre = genre;
				return;

			},
			notEpisodePage(){
				return (this.Episode == null && this.Season == null) ? true : false;
			},
			makeHref(tag){
				let Tag = tag.trim();
				return '<a href="' + this.tagUrl+Tag + '">'+Tag+'</a>'
			},
			episodes(){
				return this.v_number_of_episodes !== null? true:false;
			},
			seasonAndEps(){
				return (this.Episode == null && this.Season ==null) ? false : true; 
			},
			getSavedData(){
				let workingName = this.name.trim().replace(/\s+/g, "_");
				if (localStorage.getItem(workingName)) {
					try{
						let storedData = JSON.parse(localStorage.getItem(workingName));
						if (storedData!=null){
							this.alt= storedData.alt;
							this.image_url= storedData.image_url;
							this.v_id= storedData.v_id;
							this.v_views= storedData.v_views;
							this.v_number_of_seasons= storedData.v_number_of_seasons;
						}
					}
					catch(e){
						localStorage.removeItem(workingName);
					}
				}
			}
		},
		created(){
			this.makeGenre();
			if(this.needed || !this.isHome){
				this.getSavedData();
			}
			
		},
		mounted(){
			
			if(!this.needed && this.isHome){
				this.saveData();
			}
		}
	}
</script>
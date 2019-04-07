<template >
	<div class="d-none" v-bind:class="{'overlay': show}">
	<div class="d-block w-75 rounded mx-auto pb-3 pt-3 popupmain" style="background-color: #000000 !important; opacity: 0.9; font-family:'Comic Sans MS', cursive, sans-serif;">
	<span class="text-info d-block closebtn">
		<svg xmlns="http://www.w3.org/2000/svg" width="30.718" height="30.84" v-on:click="leave" class="change-color" viewBox="0 0 30.718 30.84">
 	 		<path id="Close" style="fill-rule: evenodd; fill:gold; cursor: pointer;" class="cls-1 change-color" d="M894.788,1176.57l12.583-12.89a1.5,1.5,0,0,0-.022-2.11,1.478,1.478,0,0,0-2.1.02l-12.561,12.87-13.081-12.89a1.479,1.479,0,0,0-2.1.02,1.5,1.5,0,0,0,.02,2.11l13.062,12.87-13.062,12.87a1.5,1.5,0,0,0-.02,2.11,1.477,1.477,0,0,0,2.1.02l13.081-12.89,12.561,12.87a1.477,1.477,0,0,0,1.062.45,1.459,1.459,0,0,0,1.04-.43,1.5,1.5,0,0,0,.022-2.11Z" transform="translate(-877.094 -1161.16)"/>
		</svg>
	</span>
		<p class="d-block text-white mobile-only" style="font-family:'Comic Sans MS', cursive, sans-serif; font-size: 10px">Request for a movie here and get its link sent to your email </p>
		<p class="d-block text-white pc-only" style="font-family:'Comic Sans MS', cursive, sans-serif;">Request for a movie here and get its link sent to your email </p>
		<p v-if="danger" class="text-danger"> please fill the form correctly</p>
		<p v-if="bademail" class="text-danger"> invalid email</p>
		<p v-if="success" class="text-success"> Your request has been sent</p>
		<div class="form-group mx-auto w-75">
			<label for="name">Input your name here</label>
			<input type="text" class="form-control bg-dark text-white" v-model="name" v-bind:class="{border:border, 'border-danger':danger}"  id="name" placeholder="please input your name here">
		</div>
		<div class="form-group mx-auto w-75">
			<label for="email">Input your email</label>
			<input type="text" class="form-control bg-dark text-white" v-model="email" v-bind:class="{border:border, 'border-danger':danger}" id="email" placeholder="e.g. john@example.com">
		</div>

		<div class="form-group mx-auto w-75" v-if="singleton">
			<label for="movie">Add the name of the movie you wish to request for</label>
			<input type="text" class="form-control bg-dark text-white" v-bind:class="{border:border, 'border-danger':danger}" v-model="movies[0]" id="movie" placeholder="e.g. X-men">
		</div>

		<div class="form-group mx-auto w-75" v-else >
			<label>Add the name of the movies you wish to request for</label>
			
			<div class="input-group mb-1" v-for="(num) in no_of_movies">
 				 <div class="input-group-prepend">
    				<span class="input-group-text bg-dark text-white">movie #{{num+1}}</span>
  				</div>
  				<input type="text" class="form-control bg-dark text-white" v-bind:class="{border:border, 'border-danger':danger}" v-model="movies[num]" placeholder="e.g. X-men">
 				<div class="input-group-append">
    				<span class="input-group-text btn text-danger bg-dark" v-on:click="remove(num)"> &#10060; </span>
  				</div>
			</div>

		</div>

		<span style="cursor: pointer" >
			<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" v-on:click="addMovie()">
  				<path id="Add" class="cls-1" style="fill-rule: evenodd; fill: #e88607" d="M453,1243a22,22,0,1,0,22,22A22.025,22.025,0,0,0,453,1243Zm0,41a19,19,0,1,1,19-19A19,19,0,0,1,453,1284Zm8-20h-6v-6a1.5,1.5,0,0,0-3,0v6h-6a1.5,1.5,0,0,0,0,3h6v6a1.5,1.5,0,0,0,3,0v-6h6A1.5,1.5,0,0,0,461,1264Z" transform="translate(-431 -1243)"/>
			</svg>
			<p class="text-info text-center" style="font-size: 10px">click here to add another movie</p>
		</span>
		<span class="text-center"> <button class="btn btn-success w-25" v-on:click="submit()"> {{status}} </button> </span>

	</div>
</div>
</template>
<script>
	export default{
		props:{
			api:{
				required: true,
				type: String,
			},
			isroute:{
				type:Boolean
			},
			isfinal:{
				type: Boolean
			}
		},
		data(){
			return {
				name: '',
				email: '',
				movies:[''],
				no_of_movies:[0],
				singleton: true,
				api2: this.api + '?',
				testApi: 'http://localhost/UdaraTV/subscribe/?',
				status: 'submit',
				border:false,
				danger:false,
				bademail: false, 
				success: false,
				isRoute: this.isroute,
				isFinal: this.isfinal,
				show: false
			}
		},
		mounted()
		{
			if(!this.isRoute && this.isFinal){
				setTimeout(function(){
                    this.show = true;
                  	}.bind(this), 15000)
			}
			if (this.isroute) {
				this.show=true;
			}

		},
		methods:{ 
		 	addMovie()
            {
                let Lnt = this.no_of_movies.length - 1;
                let mainLnt = this.no_of_movies[Lnt];
                mainLnt++;
                this.no_of_movies.push(mainLnt);
                this.movies.push('');
                this.singleton = false;
            },
            remove(num)
            {
                this.movies.splice(num,1);
                this.no_of_movies.pop();
                this.singleton = this.movies.length <= 1 ? true : false;
            },
            submit()
            {
                this.checkEmpty();
                if(this.border == true && this.danger == true){
                    return;
                }
                let movies = this.makeMovies();
                let appendage = 'name='+this.name+'&email='+this.email+'&movies='+movies;
                let api = this.api2+appendage;
                this.callApi(api);
            },
            callApi(api)
            {
                axios.get(api,
                        {headers:{ 'Content-Type':'application/json'}})
                        .then(function(response){
                           if(response.data.status == 'everything_good')
                           {
                           	this.name = '';
                           	this.email= '';
                           	this.movies = [''];
                           	this.no_of_movies=[0];
                           	this.success = true;
                           	setTimeout(function(){
                           		this.success = false;
                           	}.bind(this), 5000)
                           }
                           if(response.data.status == 'bad_email')
                           {
                           	this.bademail = true;
                           	this.setDanger();
                           }
                           if(response.data.status == 'bad_movie')
                           {
                           	this.setDanger();
                           }
                        }.bind(this))
                        .catch(function(){
                        	this.setDanger();
                        }.bind(this))
            },
            makeMovies()
            {
                let string = '';
                let lnt = this.movies.length;
                for (var i = lnt - 1; i >= 0; i--) {
                    let movie = this.movies[i];
                    string+=movie+'|';
                }
                let n = string.lastIndexOf('|');
                return string.substring(0,n);
            },
            checkEmpty()
            {
                let lnt = this.movies.length;
                let count = 0;
                for (var i = lnt - 1; i >= 0; i--) {
                    let movie = this.movies[i];
                    if(movie == null || movie===''){
                        count++;
                    }
                }

                if (!(count<lnt) || this.wrongEmail()) {
                    this.setDanger();
                }
            },
            wrongEmail()
            {
            	let email = this.email;
            	if(email===""){
            		this.bademail= true;
            		return true;

            	}
            	if(email.lastIndexOf('.')==-1 || email.lastIndexOf('@')===-1 ){
            		this.bademail= true;
            		return true;
            	}
            	return false;
            },
            setDanger()
            {
                this.danger= true;
                this.border = true;
                setTimeout(function(){
                    this.danger = false;
                    this.border = false;
                    this.bademail = false;

                }.bind(this), 5000);
            },
            leave()
            {
            	if (!this.isRoute ) {
            		this.show = false;
            	}
            	else{
            		this.show = false;
            		this.$router.replace('/');
            	}
            }

        }
			
	}
</script>
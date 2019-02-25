<template>
    	<li  class="list-group-item d-flex justify-content-between align-items-center shadow p-3 bg-dark" style="list-style-image: url('public/css/Youtube.svg')">
<a v-bind:href="purl()" class="" v-if='thetype== series'> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 42 34">
  <defs>
  </defs>
  <path id="Youtube" class="cls-1" d="M288.945,2136a7.057,7.057,0,0,1,7.055,7.06v13.88a7.057,7.057,0,0,1-7.055,7.06h-21.89a7.057,7.057,0,0,1-7.055-7.06v-13.88a7.057,7.057,0,0,1,7.055-7.06h21.89m0-3h-21.89A10.067,10.067,0,0,0,257,2143.06v13.88A10.067,10.067,0,0,0,267.055,2167h21.89A10.067,10.067,0,0,0,299,2156.94v-13.88A10.067,10.067,0,0,0,288.945,2133h0ZM275,2145l8,5-8,5v-10m0-3a2.907,2.907,0,0,0-1.454.38A2.984,2.984,0,0,0,272,2145v10a2.984,2.984,0,0,0,1.546,2.62A2.907,2.907,0,0,0,275,2158a2.943,2.943,0,0,0,1.59-.46l8-5a2.993,2.993,0,0,0,0-5.08l-8-5A2.943,2.943,0,0,0,275,2142h0Z" transform="translate(-257 -2133)"/>
</svg> <span class="d-inline-block w-1"></span> {{name}} season {{theseason}} episode {{theepisode}} [uploaded at {{thetimestamp}}]</a>

<a v-bind:href="purl()" class="" v-else> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 42 34">
  <defs>
  </defs>
  <path id="Youtube" class="cls-1" d="M288.945,2136a7.057,7.057,0,0,1,7.055,7.06v13.88a7.057,7.057,0,0,1-7.055,7.06h-21.89a7.057,7.057,0,0,1-7.055-7.06v-13.88a7.057,7.057,0,0,1,7.055-7.06h21.89m0-3h-21.89A10.067,10.067,0,0,0,257,2143.06v13.88A10.067,10.067,0,0,0,267.055,2167h21.89A10.067,10.067,0,0,0,299,2156.94v-13.88A10.067,10.067,0,0,0,288.945,2133h0ZM275,2145l8,5-8,5v-10m0-3a2.907,2.907,0,0,0-1.454.38A2.984,2.984,0,0,0,272,2145v10a2.984,2.984,0,0,0,1.546,2.62A2.907,2.907,0,0,0,275,2158a2.943,2.943,0,0,0,1.59-.46l8-5a2.993,2.993,0,0,0,0-5.08l-8-5A2.943,2.943,0,0,0,275,2142h0Z" transform="translate(-257 -2133)"/>
</svg> <span class="d-inline-block w-1"></span> {{name}} [uploaded at {{thetimestamp}}]</a>
</li>
</template>
<script>
export default{ 
	props:{
		videoname: String,
		videourl: String,
		type: String,
		episode: String,
		season: String,
		timestamp: String
	},
	data(){
		return{
			name: this.videoname,
			url: this.videourl,
			thetype: this.type,
			theepisode: this.episode,
			theseason: this.season,
			thetimestamp: this.timestamp,
			series: 'series'
		}
	},
	methods:{
		purl(){
			return this.url.replace(/\s+/g,'_');
		}
	}
}

</script>
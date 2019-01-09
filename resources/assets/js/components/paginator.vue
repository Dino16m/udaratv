<template>
<nav aria-label="..." class="row justify-content-center bg-dark" >
  <ul class="pagination pagination-lg bg-dark shadow" >
    <li class="page-item disabled bg-dark" v-if="previous()">
      <a class="page-link bg-dark" v-bind:href="values.previous_page_url" tabindex="-1">Previous</a>
    </li>
    <li v-for="(numAr, key) in numArr" v-bind:class="pageItemClass(numAr)"><a class="page-link bg-dark" :href="getHref(numAr)">{{numAr}}</a></li>
    <li class="page-item " v-if="notSinglePage()">
      <a class="page-link bg-dark" v-bind:href="values.next_page_url">Next</a>
    </li>
  </ul>
</nav>
</template>
<script >
	export default{
		props:{
			passed:{
				required: true,
				type: Object
			}
		},
		created(){
			this.populate();
		},
		data(){
			return{
				values: this.passed,
				number: this.passed.last,
				numArr: [],
				link: this.passed.path
			}
		},
		methods:{
			pageItemClass(key){
				return this.values.current_page==key ? "page-item active" : "page-item";
			},
			previous(){
				return this.values.previous_page_url!=null;
			},
			populate(){
				let length=this.number;
				for (var i = 0; i <length; i++) {
					this.numArr[i] = i + 1;
				}
			},
			getHref(key){
				return this.link+key;
			},
			notSinglePage(){
				return (this.values.last != 1);
			}
		}
	}
</script>
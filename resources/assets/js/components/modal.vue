<template>
  <div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary  d-none"  id='modal' ref='modal' data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">{{msg}}</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
</template>
<script >
  export default{
    props:{
      msg:{
        type: String,
        required: true
      }
    },
    data(){
      return{
        
    } 
  },
    methods:{
      clicked(){
        this.$refs.modal.click();
      }
    }
  }

</script>
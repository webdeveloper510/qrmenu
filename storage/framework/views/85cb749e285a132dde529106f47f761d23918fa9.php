<div class="card card-profile shadow tablepicker">
    <div class="px-4">
      <div class="mt-5">
        <h3><?php echo e(__('Table')); ?><span class="font-weight-light"></span></h3>
      </div>
      <div class="card-content border-top">
        <br />
        <input type="hidden" value="<?php echo e($restorant->id); ?>" id="restaurant_id"/>
        <?php if($tid==null): ?>
          <?php echo $__env->make('partials.select',$tables, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
          <p><?php echo e($tableName); ?></p>
          <input type="hidden" value="<?php echo e($tid); ?>" name="table_id"  id="table_id"/>
        <?php endif; ?>

      <?php 
      /*$custom_tip = $restorant['custom_tip'];
      $tips = $restorant['tips'];
      $tips_array = explode(",",$tips);?>

        @foreach($tips_array as $tips)
          <div class="tips-radio mb-3">
            <input name="tips" class="tips-input" id="tips" type="radio" value="{{$tips}}" onchange="valueChanged()"  checked>
            <label class="tips-label">{{ $tips }}%</label>
          </div>
        @endforeach

        @if($custom_tip==1)
        <div class="tips-radio mb-3"> 
          <input name="tips" class="tips-input1" id="tips" type="radio" value="" onchange="valueChanged1()">
          <label class="tips-label">{{ __('Custom $') }}</label>
          
        </div> 
        <input type="number" class="tips_input1" id="tips_input1" name="tips" >
        @endif*/?>

      </div>
      <br />
      <br />
    </div>
  </div>
  <br />
<style>
  input#tips_input {
    border: 1px solid #cad1d7 !important;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
 /* jQuery(document).ready(function(){
    
      jQuery('#tips_input1').hide();
      $('input:radio[name="tips"]').change(function(){
    
      if(jQuery('.tips-input1').is(":checked")){
        jQuery('#tips_input1').show();
      }
      else{
        jQuery('#tips_input1').hide();
      }
    });
  });
*/

</script><?php /**PATH D:\xampp\htdocs\qrmenu\resources\views/cart/localorder/table.blade.php ENDPATH**/ ?>
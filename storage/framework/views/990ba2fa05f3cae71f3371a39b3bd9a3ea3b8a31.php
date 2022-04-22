
<?php echo $__env->make('partials.input',['id'=>'vat','name'=>__('VAT percentage( for all menu items )'),'placeholder'=>__('Item VAT percentage'),'value'=>$restorant->vat==""?$restorant->getConfig('default_tax_value',0):$restorant->vat,'required'=>false,'type'=>'number'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php if(config('app.ordering')): ?>

    <h6 class="heading-small text-muted mb-4"><?php echo e(__('Orders')); ?></h6>

    <!-- <?php echo $__env->make('partials.input',['id'=>'tips','name'=>__('Tips'),'placeholder'=>__('Tips'),'value'=>$restorant->tips==""?$restorant->getConfig('default_tax_value',0):$restorant->tips,'required'=>false,'type'=>'text'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> -->
    <?php $tips_datas = explode(",",$restorant->tips);$tips_datas = array_filter($tips_datas);?>

    <label class="form-control-label">Tips</label><br>
    <div class="row">
        <div class="col-md-6">
            
            <?php if(!empty($tips_datas)): ?>
            <div class="append_checkbox">
                <?php $__currentLoopData = $tips_datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tips_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <input name="tips[]" class="tips-input" id="tips" type="checkbox" value="<?php echo $tips_data;?>" checked>
                 <label><?php echo e($tips_data); ?> %</label><button type="button" class="delete_tips" onclick="delete_tips('<?php echo $restorant->id?>','<?php echo $tips_data?>')">X</button><br>
                  
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
                <!-- <div class="append_checkbox"></div> -->
                <div class="field_wrapper">
                    <div>
                        <!-- <input type="text" name="tips[]" value=""/>  -->
                    </div>
                </div>
    
                <?php else: ?>
                 <div class="append_checkbox"></div> 
                <div class="field_wrapper">
                    <div>
                        <!-- <input type="text" name="tips[]" value=""/>  -->
                        <div  class="minus_div"><input type="text" name="tips_input" class="form-control tips_inputs" value="" id="tips_input"/><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle"></i></a></div>

                    </div>
                </div>
                <?php endif; ?>

        </div>
        <div class="col-md-6">
            <label class="form-control-label" for="tips">Custom Tip Field</label>
                <div class="material-switch" >
                    <input id="switch-primary-1" value="" name="custom_tip" type="checkbox" <?php if ($restorant->custom_tip == 1) { echo "checked"; } ?>>

                    <label for="switch-primary-1" ></label>
                </div>
        </div>
    </div>

    <div class="buttons_div">
    <a href="javascript:void(0);" class="add_button" title="Add field">+Add Preset</a>
    <button type="button" class="btn btn-success" id="save_tips">SAVE</button></div>
    <br>

    <!-- <label class="form-control-label" for="tips">Custom Tip Field</label>
    <div class="material-switch" >
        <input id="switch-primary-1" value="" name="custom_tip" type="checkbox" <?php if ($restorant->custom_tip == 1) { echo "checked"; } ?>>

        <label for="switch-primary-1" ></label>
    </div> -->

    <?php echo $__env->make('partials.fields',['fields'=>[
        ['required'=>true,'ftype'=>'input','type'=>'number','placeholder'=>"Minimum order",'name'=>'Minimum order', 'additionalInfo'=>'Enter Minimum order value', 'id'=>'minimum', 'value'=>$restorant->minimum],
        ['required'=>true,'ftype'=>'select','placeholder'=>"",'name'=>'Average order prepare time in minutes', 'id'=>'custom[time_to_prepare_order_in_minutes]','data'=>[0=>0,5=>5,10=>10,15=>15,20=>20,25=>25,30=>30,35=>35,40=>40,45=>45,50=>50,60=>60,90=>90,120=>120],'value'=>$restorant->getConfig('time_to_prepare_order_in_minutes',config('settings.time_to_prepare_order_in_minutes'))],
        ['required'=>true,'ftype'=>'select','placeholder'=>"",'name'=>'Time slots separated in minutes', 'id'=>'custom[delivery_interval_in_minutes]','data'=>[5=>5,10=>10,15=>15,20=>20,25=>25,30=>30,35=>35,40=>40,45=>45,50=>50,60=>60,90=>90,120=>120],'value'=>$restorant->getConfig('delivery_interval_in_minutes',config('settings.delivery_interval_in_minutes'))]
    ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    
            <?php endif; ?>

<style type="text/css">
.material-switch > input[type="checkbox"] {
  display: none;
}

.material-switch > label {
  cursor: pointer;
  height: 0px;
  position: relative;
  top: 2px;
  width: 40px;
}

.material-switch > label::before {
  background: rgb(0, 0, 0);
  box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
  border-radius: 8px;
  content: '';
  height: 16px;
  margin-top: -8px;
  position: absolute;
  opacity: 0.3;
  transition: all 0.4s ease-in-out;
  width: 40px;
}

.material-switch > label::after {
  background: rgb(255, 255, 255);
  border-radius: 16px;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
  content: '';
  height: 24px;
  left: -4px;
  margin-top: -8px;
  position: absolute;
  top: -4px;
  transition: all 0.3s ease-in-out;
  width: 24px;
}

.material-switch > input[type="checkbox"]:checked + label::before {
  background: inherit;
  opacity: 0.5;
}

.material-switch > input[type="checkbox"]:checked + label::after {
  background: inherit;
  left: 20px;
}
input#tips_input {
    border: 1px solid #cad1d7 !important;
}
button.delete_tips {
    padding: 0px 20px;
    margin-left: 30px;
    border: 1px solid #000000;
}

button#save_tips {
    margin-left: 20px;
}

.buttons_div {
    margin-top: 20px;
}


a.remove_button {
    align-items: center;
    justify-content: center;
    display: flex;
    margin-left: 20px;
}

.minus_div {
    display: flex;
}

input#vat {
    width: 75px !important;
    border: 2px solid #000000;
}
span.prec {
    left: 80px;
    position: relative;
    bottom: 35px;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $('input[name=custom_tip]').change(function(){
   
    var id=$( this ).val();
    if(id==0)
    {
        $( this ).val(1);
         $( this ).attr('checked','checked');
    }
    else
    {
        $( this ).val(0);
        $( this ).removeAttr('checked');
    }

    
  });  
    $('<span class="prec">%</span>').insertAfter('#vat');
  

    $(document).ready(function(){
        
       //$("#save_tips").hide();
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div  class="minus_div"><input type="text" name="tips_input" class="form-control tips_inputs" value="" id="tips_input"/><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus-circle"></i></a></div></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        
        $(addButton).click(function(){

            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            //$("#save_tips").hide();
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    $('#save_tips').click(function(){
        
        var tips_val = $('.tips_inputs').val();
        var restaurant_id ='<?php echo $restorant->id?>';
        if(tips_val==""){
            alert("enter value");
        }
        else{

            $(".tips_inputs").each(function( index ) {
               var input_val=  $(this).val();
               //var input_html=  $(this).html();
               
               var input_html=  $(this).parent().html();
               //$(input_html).remove();
               //$('.append_checkbox').append('<input name="tips[]" class="tips-input" id="tips" type="checkbox" value="'+input_val+'">&nbsp;<label>'+input_val+' %</label><button type="button" class="delete_tips" id="" onclick="function delete_tips('+restaurant_id+','+input_val+')">X</button><br>');
               $('.append_checkbox').append('<input name="tips[]" class="tips-input" id="tips" type="checkbox" value="'+input_val+'"><label style="padding-left:4px">'+input_val+' %</label><button type="button" class="delete_tips" id="" onclick="delete_tips_before_save('+restaurant_id+','+input_val+')">X</button><br>');
               
            });
        }
            
    });
    function delete_tips(restaurant_id,tips){
        var url = <?php echo json_encode(url('/')); ?>

       
        $.ajax({

            url : url+'/delete_tips',
            type : 'POST',
            data : {
                'restaurant_id' : restaurant_id,'tips':tips,'_token':'<?php echo e(csrf_token()); ?>'
            },
            //dataType   :'json',
            
            success : function(data) {              
                //alert('Data: '+data);
                //location.reload()
                $('input[value="'+tips+'"]').next().next().remove();
                $('input[value="'+tips+'"]').next().remove();
                $('input[value="'+tips+'"]').remove();
            },
            
        });
    }
    function delete_tips_before_save(restaurant_id,tips){
        //alert(restaurant_id);
        //alert(tips);
        var url = <?php echo json_encode(url('/')); ?>

        //$('input[value="'+tips+'"]').prev().remove();
        
        $('input[value="'+tips+'"]').html().replace(/&nbsp;/gi, '');
        $('input[value="'+tips+'"]').next().next().next().next().remove();
        $('input[value="'+tips+'"]').next().next().next().remove();
        $('input[value="'+tips+'"]').next().next().remove();
        $('input[value="'+tips+'"]').next().remove();
        $('input[value="'+tips+'"]').remove();

    }
    </script><?php /**PATH D:\xampp\htdocs\qrmenu\resources\views/restorants/partials/ordering.blade.php ENDPATH**/ ?>
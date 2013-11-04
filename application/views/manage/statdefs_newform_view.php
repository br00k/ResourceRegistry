<div id="pagetitle"><?php echo lang('newstatdefform');?></div>
<div id="subtitle"><h3><?php echo anchor(base_url().'providers/detail/show/'.$providerid, $providername ) ;?></h3><h4><?php echo $providerentity;?></h4>
     <h5><?php echo anchor(base_url().'manage/statdefs/show/'.$providerid,lang('statdeflist')) ;?></h5>
</div>

<div>
<?php
$attributes = array('class' => 'email', 'id' => 'formver2');
echo form_open(''. base_url() . 'manage/statdefs/newstatdef/'.$providerid.'', $attributes);
 $errors_v = validation_errors('<span class="span-12">', '</span><br />');
    if (!empty($errors_v)) {
        echo '<div class="error">';
        echo $errors_v;
        echo "</div>";
    }

?>
<fieldset>
 <legend><?php echo lang('rr_statdefbasicgroup');?></legend>
  <ol>
   <li>
     <label for="defname"><?php echo lang('rr_statdefshortname');?></label>
     <input type="text" id="defname" name="defname" required="required" value="<?php echo set_value('defname');?>"/>
   </li>
   <li>
     <label for="titlename"><?php echo lang('rr_statdeftitle');?></label>
     <input type="text" id="titlename" name="titlename" required="required" value="<?php echo set_value('titlename');?>"/>
   </li>
   <li>
     <label for="description"><?php echo lang('rr_statdefdesc');?></label>
     <textarea id="description" name="description" required="required" cols="65" rows="10"><?php echo set_value('description');?></textarea>
   </li>
   <li>
     <label for="overwrite"><?php echo lang('rr_overwritestatfile');?></label>
     <input type="checkbox" name="overwrite" id="overwrite" value="yes" <?php echo set_checkbox('overwrite', 'yes'); ?> style="margin:10px" />
      
   </li>
  </ol>
</fieldset>
<?php 

 if(!empty($showpredefined) && $showpredefined === TRUE)
{
?>
<fieldset>
<legend><?php echo lang('builtinstatdefs');?></legend>
<?php
echo '<div>'.lang('youcanshoose').':<br />'.$workersdescriptions.'</div>';
?>
<ol>
<li>
<label for="usepredefined"><?php echo lang('plsusepredefstat') ;?></label>
<input type="checkbox" name="usepredefined" id="usepredefined" value="yes" <?php echo set_checkbox('usepredefined', 'yes'); ?> style="margin:10px" />
</li>
<li>
<label for="gworker"><?php echo lang('listavailableprestats');?></label>
<?php
 echo form_dropdown('gworker',$workerdropdown,$this->input->post('gworker'), "id='gworker'");
?>
</li>
</ol>
</fieldset>
<?php
}
?>
<fieldset id="stadefext">
<?php 
  if(!empty($showpredefined) && $showpredefined === TRUE)
  {
?>
 <legend><?php echo lang('rr_statdefconngroup'). ' '.showBubblehelp(''.lang('rhelp_extstatleg').'').'';?></legend>
<?php
  }
  else
  {
?>
 <legend><?php echo lang('rr_statdefconngroup') ;?></legend>

<?php
  }
?>
  <ol>
    <li>
     <label for="sourceurl"><?php echo lang('rr_statdefsourceurl') .' '.showBubbleHelp(''.lang('rr_allowedtransfprots').': http,https,ftp,ftps').'';?> </label>
     <input type="text" id="sourceurl" name="sourceurl"  value="<?php echo set_value('sourceurl');?>"/>
    </li>
    <li>
     <label for="httpmethod"><?php echo lang('rr_httpmethod');?></label>
     <?php
        echo form_dropdown('httpmethod',array('get'=>'GET','post'=>'POST'),$this->input->post('httpmethod'), "id='httpmethod'");
      ?>
    </li>
    <li>
     <?php
       $example = 'attr1=value1, attr2=value2, attr3=value3';
       $exampleconvert= 'attr1<b>&#36;:&#36;</b>value1<b>&#36;&#36;</b>attr2<b>&#36;:&#36;</b>value2<b>&#36;&#36;</b>attr3<b>&#36;:&#36;</b>value3';
    ?>
     <label for="postoptions"><?php echo lang('rr_postoptions').' '.showBubbleHelp(''.lang('rr_postoptionshelp').'<br />'.lang('rr_example').''.lang('if').':'.$example.'<br />'.lang('write').': '.$exampleconvert.'');?></label>

     <textarea id="postoptions" name="postoptions"></textarea> 

    </li>
    <li>
     <label for"formattype"><?php echo lang('rr_statdefformat'); ?></label>
     <?php
       $formats = array('image'=>'image (png, jpg, if)','svg'=>'image (svg)');
       echo form_dropdown('formattype',$formats, $this->input->post('formattype'), "id='formattype'");
     ?>
    </li>
    <li>
      <label for="accesstype"><?php echo lang('rr_statdefaccess');?></label>
      <?php
        echo form_dropdown('accesstype',array('anon'=>''.lang('rr_anon').'','basicauthn'=>''.lang('rr_basicauthn').''),$this->input->post('accesstype'), "id='accesstype'");
      ?>
    </li>
    <li>
      <label for="userauthn"><?php echo lang('rr_username') .' '.showBubbleHelp(''.lang('rhelp_stadefuserauthn').'') ;?> </label>
      <input type="text" id="userauthn" name="userauthn" value="<?php echo set_value('userauthn');?>"/>
    </li>
    <li>
      <label for="passauthn"><?php echo lang('rr_password') .' '.showBubbleHelp(''.lang('rhelp_stadefuserauthn').'') ;?> </label>
      <input type="password" id="passauthn" name="passauthn" value=""/>
    </li>
   
  
  </ol>
</fieldset>
<fieldset>
  <div class="buttons">
      <button type="submit" name="submit" value="submit" class="savebutton saveicon">
            <?php echo lang('rr_add');?></button>

  </div> 
</fieldset>

<?php
echo form_close();
?>

</div>

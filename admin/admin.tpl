<div class="titrePage">
<h2>Lightbox</h2>
</div>

<form action="" method="post">

<fieldset>
<legend>{'lb_display'|@translate}</legend>
<table>
  <tr>
    <td align="right">{'lb_display_name'|@translate} : &nbsp;&nbsp;</td>
    <td><input type="radio" name="display_name" value="1" {if $DISPLAY_NAME}checked="checked"{/if} onClick="javascript: jQuery('.name_link').show();"> {'lb_yes'|@translate} &nbsp;
        <input type="radio" name="display_name" value="0" {if !$DISPLAY_NAME}checked="checked"{/if} onClick="javascript: jQuery('.name_link').hide();"> {'lb_no'|@translate}
    </td>
  </tr>

  <tr class="name_link"><td>&nbsp;</td></tr>
  
  <tr class="name_link">
    <td align="right">{'lb_name_link'|@translate} : &nbsp;&nbsp;</td>
    <td><select name="name_link">
          <option label="{'lb_picture'|@translate}" value="picture" {if $NAME_LINK == 'picture'}selected="selected"{/if}>{'lb_picture'|@translate}</option>
          <option label="{'lb_high'|@translate}" value="high" {if $NAME_LINK == 'high'}selected="selected"{/if}>{'lb_high'|@translate}</option>
          <option label="{'lb_none'|@translate}" value="none" {if $NAME_LINK == 'none'}selected="selected"{/if}>{'lb_none'|@translate}</option>
        </select>
    </td>
  </tr>

  <tr><td>&nbsp;</td></tr>

  <tr>
    <td align="right">{'lb_display_arrows'|@translate} : &nbsp;&nbsp;</td>
    <td><input type="radio" name="display_arrows" value="1" {if $DISPLAY_ARROWS}checked="checked"{/if} onClick="javascript: jQuery('.all_cat').show();"> {'lb_yes'|@translate} &nbsp;
        <input type="radio" name="display_arrows" value="0" {if !$DISPLAY_ARROWS}checked="checked"{/if} onClick="javascript: jQuery('.all_cat').hide();"> {'lb_no'|@translate}
    </td>
  </tr>

  <tr class="all_cat"><td>&nbsp;</td></tr>

  <tr class="all_cat">
    <td align="right">{'lb_all_category'|@translate} : &nbsp;&nbsp;</td>
    <td><input type="radio" name="all_cat" value="1" {if $ALL_CAT}checked="checked"{/if}> {'lb_yes'|@translate} &nbsp;
        <input type="radio" name="all_cat" value="0" {if !$ALL_CAT}checked="checked"{/if}> {'lb_no'|@translate}
    </td>
  </tr>

  <tr><td>&nbsp;</td></tr>
</table>
</fieldset>

<fieldset>
<legend>{'lb_theme_transition'|@translate}</legend>
<table>
  <tr>
    <td align="right">{'lb_theme'|@translate} : &nbsp;&nbsp;</td>
    <td><select name="theme">
          {foreach from=$colorbox_themes item=colorbox_theme key=i}
          <option label="{$theme|@ucwords}" value="{$colorbox_theme}" {if $SELECTED_THEME == $colorbox_theme}selected="selected"{/if}>{$colorbox_theme|@ucwords}</option>
          {/foreach}
        </select>
    </td>
  </tr>
  
  <tr><td>&nbsp;</td></tr>

  <tr>
    <td align="right">{'lb_transition'|@translate} : &nbsp;&nbsp;</td>
    <td><select name="transition">
          <option label="{'lb_transition_elastic'|@translate}" value="elastic" {if $SELECTED_TRANSITION == 'elastic'}selected="selected"{/if}>{'lb_transition_elastic'|@translate}</option>
          <option label="{'lb_transition_fade'|@translate}" value="fade" {if $SELECTED_TRANSITION == 'fade'}selected="selected"{/if}>{'lb_transition_fade'|@translate}</option>
          <option label="{'lb_transition_none'|@translate}" value="none" {if $SELECTED_TRANSITION == 'none'}selected="selected"{/if}>{'lb_transition_none'|@translate}</option>
        </select>
    </td>
  </tr>

  <tr><td>&nbsp;</td></tr>

  <tr>
    <td align="right">{'lb_transition_speed'|@translate} : &nbsp;&nbsp;</td>
    <td><input type="text" size="2" maxlength="3" name="transition_speed" value="{$TRANSITION_SPEED}"> ms</td>
  </tr> 
  
  <tr><td>&nbsp;</td></tr>
</table>
</fieldset>

<fieldset>
<legend>{'lb_dimensions'|@translate}</legend>
<table>
  <tr>
    <td align="right">{'lb_initial_width'|@translate} : &nbsp;&nbsp;</td>
    <td><input type="text" size="2" maxlength="3" name="initial_width" value="{$INITIAL_WIDTH}">&nbsp;&nbsp;
        <input type="radio" name="initial_width_px" value="px" {if $INITIAL_WIDTH_PX}checked="checked"{/if}> px &nbsp;
        <input type="radio" name="initial_width_px" value="%" {if !$INITIAL_WIDTH_PX}checked="checked"{/if}> %</td>
  </tr>
  <tr>
    <td align="right">{'lb_initial_height'|@translate} : &nbsp;&nbsp;</td>
    <td><input type="text" size="2" maxlength="3" name="initial_height" value="{$INITIAL_HEIGHT}">&nbsp;&nbsp;
        <input type="radio" name="initial_height_px" value="px" {if $INITIAL_HEIGHT_PX}checked="checked"{/if}> px &nbsp;
        <input type="radio" name="initial_height_px" value="%" {if !$INITIAL_HEIGHT_PX}checked="checked"{/if}> %</td>
  </tr>

  <tr><td>&nbsp;</td></tr>

  <tr>
    <td align="right">{'lb_fixed_width'|@translate} : &nbsp;&nbsp;</td>
    <td><input type="text" size="2" maxlength="3" name="fixed_width" value="{$FIXED_WIDTH}">&nbsp;&nbsp;
        <input type="radio" name="fixed_width_px" value="px" {if $FIXED_WIDTH_PX}checked="checked"{/if}> px &nbsp;
        <input type="radio" name="fixed_width_px" value="%" {if !$FIXED_WIDTH_PX}checked="checked"{/if}> %</td>
  </tr>
  <tr>
    <td align="right">{'lb_fixed_height'|@translate} : &nbsp;&nbsp;</td>
    <td><input type="text" size="2" maxlength="3" name="fixed_height" value="{$FIXED_HEIGHT}">&nbsp;&nbsp;
        <input type="radio" name="fixed_height_px" value="px" {if $FIXED_HEIGHT_PX}checked="checked"{/if}> px &nbsp;
        <input type="radio" name="fixed_height_px" value="%" {if !$FIXED_HEIGHT_PX}checked="checked"{/if}> %</td>
  </tr>

  <tr><td>&nbsp;</td></tr>
</table>
</fieldset>

<p><input type="submit" name="submit" value="{'Submit'|@translate}" {$TAG_INPUT_ENABLED}>
<input type="submit" name="restore" value="{'lb_default_parameters'|@translate}" onclick="return confirm('{'Are you sure?'|@translate|@escape:'javascript'}');" {$TAG_INPUT_ENABLED}></p>
</form>

<script type="text/javascript">
if (document.getElementsByName("display_name")[1].checked == true)
  jQuery('.name_link').hide();
if (document.getElementsByName("display_arrows")[1].checked == true)
  jQuery('.all_cat').hide();
</script>
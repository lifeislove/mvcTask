<div class="users form">
	<?php echo $this->Form->create('User', array('type' => 'file', 'enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Edit Profile'); ?></legend>
		<?php
		echo $this->Html->image('Profiles/' .(!empty($data['User']['profile_pic'])?$data['User']['profile_pic']:'default.png'),array('width'=>'250px','height'=>'250px'));
		echo $this->Form->input('profile_pic.', array(
				'type' => 'file',
				'id' => 'profile_pic',
				'label' => 'Profile Picture',
				'required' => 'false',
				'accept' => '.jpg,.jpeg,.png',
				'multiple' => true,
				'label' => false,
				'div' => false
		));
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('address');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('country');
		echo $this->Form->input('zipcode');
		?>
		<label class="label"><b>Timezone<span style="color:#ee3322;">*</span></b></label>
		<?php
		echo $this->Form->select('timezone', array($timezones), array(
				'empty' => 'Choose Timezone',
				'type' => 'select',
				'label' => true,
				'div' => true,
				'class' => 'input-sm',
				'required' => 'true',
		));
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('View'), array('action' => 'view')); ?></li>
		<li><?php echo $this->Html->link(__('Logout'), array('controller' => 'Users', 'action' => 'logout')); ?></li>
	</ul>
</div>

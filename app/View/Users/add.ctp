<div class="users form">

<?php echo $this->Form->create('User', array('type' => 'file', 'enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Register'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
        echo $this->Form->input('email');
        echo $this->Form->input('phone');
        echo $this->Form->input('address');
        echo $this->Form->input('city');
        echo $this->Form->input('state');
        echo $this->Form->input('country');
        echo $this->Form->input('zipcode');
        ?>
		<label class="label"><b>Timezone<span style="color:#e32;">*</span></b></label>
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
		<label class="label"><b>Profile Picture<span style="color:#e32;">*</span></b></label>
		<?php

		echo $this->Form->input('profile_pic.', array(
			'type' => 'file',
			'id' => 'profile_pic',
			'label' => 'Profile Picture',
			'required' => 'true',
			'accept' => '.jpg,.jpeg,.png',
			'multiple' => true,
			'label' => false,
			'div' => false
		));

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Login'), array('controller' => 'Users', 'action' => 'login')); ?></li>
	</ul>
</div>

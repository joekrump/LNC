<nav>
	<ul id="top-menu">
		<a href="index.php" ><li>Home</li></a>
		<!--<li><a href="">Work Samples</a>
			<div class="one_column_layout">
				<div class="col_1">
					<ul >
						<a href="pc.php"><li class="option">PC Building</li></a>
						<a href="nxt-project.php"><li class="option">Java - Lego NXT Project</li></a>
					</ul>
				</div>
			</div>
		</li>-->
		<?php 
			if($user->logged_in()){ 
		?>
				<a href="references.php"><li>References</li></a>
				<a href="chatroom.php?mode=<?php echo $user_data['email_code']; ?>"><li>Chat</li></a> 
		<?php	}
		?>
		<!--<a href="downloads.php"><li>Downloads</li></a>-->		
		<a href="contact.php"><li>Contact Us</li></a>
	</ul>
</nav>

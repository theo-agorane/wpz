<section id="acf-admin-tools" class="wrap">
	<?php if (!empty($notice)) : ?>
	    <div class="blocks-notice blocks-notice-<?php echo $notice[1]; ?>">
	        <p><?php echo $notice[0]; ?></p>
	    </div>
	<?php endif; ?>
	<div class="acf-meta-box-wrap -grid">
		<div id="normal-sortables" class="meta-box-sortables">
			<div class="postbox">
				<div class="inside">
					<div class="acf-postbox-header">
						<h2 class="acf-postbox-title">Liste des Blocks</h2>
					</div>
					<div class="acf-postbox-inner">
						<table class="list-blocks">
							<?php foreach ($blocks as $block => $details) : ?>
								<tr class="block">
									<td class="block-name">
										<?php echo $block; ?>
										<em>Créé le <?php echo date('d/m/Y \à H:i', $details['created']); ?></em>
									</td>
									<td class="block-button">
										<form method="post" class="blocks-delete">
											<input type="submit" class="acf-btn-sm acf-btn acf-btn-tertiary" value="Supprimer">
											<input type="hidden" value="<?php echo $block; ?>" name="blocks-delete-key">
											<?php wp_nonce_field('blocks-delete-' . $block); ?>
										</form>
									</td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
			<div class="postbox">
				<form method="post" class="blocks-create">
					<div class="inside">
						<div class="acf-postbox-header">
							<h2 class="acf-postbox-title">Ajouter un Block</h2>
						</div>
						<div class="acf-postbox-inner">
							<label for="blocks-create-key">ID du Block</label>
							<em>Seulement des lettres. Majuscules avant chaque mot.</em>
							<input type="text" name="blocks-create-key" id="blocks-create-key" placeholder="ex: SuperBlock" required>
							<label for="blocks-create-name">Titre du Block</label>
							<input type="text" name="blocks-create-name" id="blocks-create-name" placeholder="ex: Un super Block" required>
							<input type="submit" value="Générer le Block" class="acf-btn">
							<?php wp_nonce_field('blocks-create'); ?>
						</div>
					</div>
				</form>
			</div>
			<div class="postbox">
				<form method="post" class="blocks-update">
					<div class="inside">
						<div class="acf-postbox-header">
							<h2 class="acf-postbox-title">Regénérer les assets</h2>
						</div>
						<div class="acf-postbox-inner">
							<input type="hidden" name="blocks-update" value="1">
							<input type="submit" value="Regénérer les assets" class="acf-btn">
							<?php wp_nonce_field('blocks-update'); ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
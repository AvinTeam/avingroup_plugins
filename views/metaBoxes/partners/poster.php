      <div class="partners-poster-upload">
          <input type="hidden" id="partners_poster_id" name="partners[poster]" value="<?php echo $poster_id ?>" />
          <div id="partners_poster_preview">
              <?php echo $poster_image ?>
          </div>
          <p>
              <input type="button" class="button button-secondary" id="partners_poster_upload_btn"
                  value="آپلود پوستر" />
              <input type="button" class="button button-secondary" id="partners_poster_remove_btn" value="حذف پوستر"
                  <?php echo empty($poster_id) ? 'style="display:none;"' : '' ?> />
          </p>
      </div>
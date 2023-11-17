<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://votingplugin.xyz
 * @since      1.0.0
 *
 * @package    Voting_Plugin_Hrvoje
 * @subpackage Voting_Plugin_Hrvoje/public/partials
 */
?>
<div class="voting-block-wrapper">
    <div class="voting-block-buttons-inner" >
        <div class="pre-vote-section">
            <div class="voting-text">
                <span class="pre-voting-text"><?php echo __('Was this article helpful?','voting-plugin-hrvoje'); ?></span>
            </div>
            <div class="voting-buttons">

                    <button class="vote-button" data-post-id="<?php echo get_the_ID(); ?>" data-vote-type="yes" >YES</button>
                    <button class="vote-button" data-post-id="<?php echo get_the_ID(); ?>" data-vote-type="no">NO</button>

            </div>
        </div>

        <div class="post-vote-section">

            <div class="voting-text">
                <span class="post-voting-text"><?php echo __('Thank you for your feedback?','voting-plugin-hrvoje'); ?></span>
            </div>
            <div class="voting-results">
                <div class="yes-average voting-average" ><span class="results-percentage"></span>%</div>
                <div class="no-average voting-average" ><span class="results-percentage"></span>%</div>
            </div>
        </div>
    </div>
</div>
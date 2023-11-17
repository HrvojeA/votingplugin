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

$disabled = $post_vote  = '';
$visitor_voted = $this->checkVisitorVoteStatus(get_the_ID());

$votes_percentage = array('yes_percentage' => 0,'no_percentage' => 0);

if($visitor_voted){

    // catastrophic I know
    $votes_count = $this->fetchVotesCount(get_the_ID());

    $votes_percentage = $this->calculateVotingPercentage($votes_count['yes_votes_count'],$votes_count['no_votes_count']);

    $disabled = ' disabled ';
    $post_vote = ' post-vote '.$visitor_voted['vote_type'].'-existing-vote';

}
?>
<div class="voting-block-wrapper <?php echo $post_vote; ?> ">
    <div class="voting-block-buttons-inner" >
        <div class="pre-vote-section">
            <div class="voting-text">
                <span class="pre-voting-text"><?php echo __('Was this article helpful?','voting-plugin-hrvoje'); ?></span>
            </div>
            <div class="voting-buttons">

                    <button class="vote-button yes-button" <?php echo $disabled; ?> data-post-id="<?php echo get_the_ID(); ?>" data-vote-type="yes" >YES</button>
                    <button class="vote-button  no-button " <?php echo $disabled; ?>  data-post-id="<?php echo get_the_ID(); ?>" data-vote-type="no">NO</button>

            </div>
        </div>

        <div class="post-vote-section">

            <div class="voting-text">
                <span class="post-voting-text"><?php echo __('Thank you for your feedback.','voting-plugin-hrvoje'); ?></span>
            </div>
            <div class="voting-results">
                <div class="yes-average voting-average " ><span class="results-percentage"><?php echo $votes_percentage['yes_percentage']; ?></span>%</div>
                <div class="no-average voting-average " ><span class="results-percentage"><?php echo $votes_percentage['no_percentage']; ?></span>%</div>
            </div>
        </div>
    </div>
</div>
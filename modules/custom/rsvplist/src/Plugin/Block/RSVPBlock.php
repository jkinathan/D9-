<?php
/**
 * @file
 * contains \Drupal\rsvplist\Plugin\Block\RSVPBlock
 */

 namespace Drupal\rsvplist\Plugin\Block;
 use Drupal\Core\Block\BlockBase; //extending your class from
 use Drupal\Core\Session\AccountInterface;//control access to block later
 use Drupal\Core\Access\AccessResult;//check Api block docs

/**
 * Provides an 'RSVP' List Block
 * @Block(
 *   id= "rsvp_block",
 *   admin_lael = @Translation("RSVP Block"),
 *  )
 */

 class RSVPBlock extends BlockBase{
    
    public function build(){
        return array('#markup' => $this->t('My RSVP List Block'));
    }
 }

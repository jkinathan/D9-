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
        return \Drupal::formBuilder()->getForm('Drupal\rsvplist\Form\RSVPForm'); 
        //gets the rsvp form and attaches it to the block
    }
    //set up access to it
    public function blockAccess(AccountInterface $account){
        /** @var \Drupal\node\Entity\Node $node */
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        /** @var \Drupal\rsvplist\EnablerService $enabler */
        $enabler = \Drupal::service('rsvplist.enabler');
        if(is_numeric($nid)){
            if($enabler->isEnabled($node)){
                return AccessResult::allowedIfHasPermission($account, 'view rsvplist');

            }
        }
        return AccessResult::forbidden();
    }
 }

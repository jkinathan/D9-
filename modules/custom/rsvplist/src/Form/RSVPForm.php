<?php
/**
 * @file
 * Contains \Drupal\rsvplist\Form\RSVPForm
 */

  namespace Drupal\rsvplist\Form;

  use Drupal\Core\Database\Database;
  use Drupal\Core\Form\FormBase;
  use Drupal\Core\Form\FormStateInterface;
  use Drupal\node\NodeInterface;
 /**
  * Provides an RSVP Email Form
  */
  class RSVPForm extends FormBase{
    /**
     * (@inheritdoc)
     */
    public function getFormId(){
      return 'rsvplist_email_form';
    //   this is our id for this form, every form in drupal has an id
    }
    
    public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL){
        // $node = \Drupal::routeMatch()->getParameter('node');
        // $nid = $node->nid->value;
        // if ($node instanceof \Drupal\node\NodeInterface) {
        //     // You can get nid
        //   $nid = $node->id();
        // }

        $form['email'] = array(
            '#title' => t('Email Address'),//the t is for translation to other languages
            '#type' => 'textfield',
            '#size' => 25,
            '#description' => t('We will send updates to the email address you provice'),
            '#required' => TRUE,
        );
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('RSVP'),
        );
        // $form['nid'] = array(
        //     '#type' => 'hidden',
        //     '#value' => $nid,
        // );

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state){
        
        $value = $form_state->getValue('email');
        
        if($value == !\Drupal::service('email.validator')->isValid($value)){

            $form_state->setErrorByName('email', t('The Email %mail is invalid.', array('%mail' => $value)));
          return;
        }
        $node = \Drupal::routeMatch()->getParameter('node');
        // Check if email already is set for this node
        $select = Database::getConnection()->select('rsvplist', 'r');
        $select->fields('r', array('nid'));
        $select->condition('nid', $node->id());
        $select->condition('mail', $value);
        $results = $select->execute();
        if (!empty($results->fetchCol())) {
          // We found a row with this nid and email.
          $form_state->setErrorByName('email', t('The address %mail is already subscribed to this list.', array('%mail' => $value)));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // \Drupal::messenger()->addMessage(t('The Form is Working.'));
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id()); 
        //grabs the current user logged in, study to get differnt variables in drupal
        \Drupal::database()->insert('rsvplist')
          ->fields(array(
            'mail' => $form_state->getValue('email'),//get the value of the email field
            'nid' => $form_state->getValue('nid'), //get value of node id
            'uid' => $user->id(),
            'created' => time(),
          ))
          ->execute();
        \Drupal::messenger()->addMessage(t('Thank you for your RSVP, you are on the list for the event.'));

    }
  }

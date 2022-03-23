<?php

namespace Wagaia;

use DateTime;
use Intervention\Image\ImageManagerStatic as Image;


class User extends Database
{
    protected $table = "wagaia_user_pb";

    public $profile;
    protected $input;
    protected $files;


    public function __construct($id = null)
    {
        parent::__construct();

        $this->input = $_POST;
        $this->files = $_FILES;

        if(!empty($id)) {
            $this->find($id);
        }

    }

    public function find($id)
    {

        $sql = "SELECT * FROM ".$this->table." WHERE id = ".$id;
        $this->profile = $this->get($sql);

        if($this->profile->birthdate != '0000-00-00' && !empty($this->profile->birthdate)) {
            $birthdate = DateTime::createFromFormat('Y-m-d', $this->profile->birthdate);
            $this->profile->date_format = $birthdate->format('d/m/Y');
        }

        unset($this->profile->password_decrypt);
        unset($this->profile->password);

    }

    public function create()
    {
        $birthdateSql = $this->formatBirthDate();

        $sql = "INSERT INTO ".$this->table." (birth_location_id, status, sexe, lastname, firstname, comments, email, 
                    birthdate, address_1, address_2, address_zipcode, address_city, bank, bank_address, bank_zipcode, 
                    bank_city, bank_iban, bank_bic, phone_mobile, phone_other, website, nb_property, dist_property)
                 VALUES (
                    '" . $this->escape($this->input['birth_location_id']) . "',
                    '" . $this->escape($this->input['status']) . "',
                    '" . $this->escape($this->input['sexe']) . "',
                    '" . $this->escape($this->input['lastname']) . "',
                    '" . $this->escape($this->input['firstname']) . "',
                    '" . $this->escape($this->input['comments']) . "',
                    '" . $this->escape($this->input['email']) . "',
                    '" . $this->escape($birthdateSql) . "',
                   '" . $this->escape($this->input['address_1']) . "',
                   '" . $this->escape($this->input['address_2']) . "',
                   '" . $this->escape($this->input['address_zipcode']) . "',
                   '" . $this->escape($this->input['address_city']) . "',
                   '" . $this->escape($this->input['bank']) . "',
                   '" . $this->escape($this->input['bank_address']) . "',
                   '" . $this->escape($this->input['bank_zipcode']) . "',
                   '" . $this->escape($this->input['bank_city']) . "',
                   '" . $this->escape($this->input['bank_iban']) . "',
                   '" . $this->escape($this->input['bank_bic']) . "',
                   '" . $this->escape($this->input['phone_mobile']) . "',
                   '" . $this->escape($this->input['phone_other']) . "',
                   '" . $this->escape($this->input['website']) . "',
                   '" . $this->escape($this->input['nb_property']) . "',
                   '" . $this->escape($this->input['dist_property']) . "'
                 )";
        $this->query($sql);
        $lastID = $this->last_id();

        $this->find($lastID);

        $this->addPhoto();
        $this->addSignature();

        return $lastID;
    }

    public function update($fromAccount = false) {

        $birthdateSql = $this->formatBirthDate();

        $sql = "UPDATE " . $this->table . " SET
                status = '" . $this->input['status'] . "',
                sexe = '" . $this->input['sexe'] . "',
                birth_location_id = '" . $this->input['birth_location_id'] . "',
                lastname = '" . $this->escape($this->input['lastname']) . "',
                firstname = '" . $this->escape($this->input['firstname']) . "',
                comments = '" . $this->escape($this->input['comments']) . "',
                phone_mobile = '" . $this->input['phone_mobile'] . "',
                phone_other = '" . $this->input['phone_other'] . "',
                website = '" . $this->input['website'] . "',
                nb_property = '" . $this->input['nb_property'] . "',
                dist_property = '" . $this->input['dist_property'] . "',
                address_1 = '" . $this->escape($this->input['address_1']) . "',
                address_2 = '" . $this->escape($this->input['address_2']) . "',
                address_zipcode = '" . $this->input['address_zipcode'] . "',
                address_city = '" . $this->escape($this->input['address_city']) . "',
                bank = '" . $this->input['bank'] . "',
                bank_address = '" . $this->escape($this->input['bank_address']) . "',
                bank_zipcode = '" . $this->input['bank_zipcode'] . "',
                bank_city = '" . $this->escape($this->input['bank_city']) . "',
                bank_iban = '" . $this->input['bank_iban'] . "',
                bank_bic = '" . $this->input['bank_bic'] . "',
                birthdate = '" . $birthdateSql . "'
             WHERE id = " . $this->profile->id;
        $this->query($sql);


        if(!$fromAccount) {

            $sql = "UPDATE " . $this->table . " SET
                        email = '" . $this->input['email'] . "'
                 WHERE id = " . $this->profile->id;
            $this->query($sql);

        }


        if(!empty($this->input['del_img']))  $this->deletePhoto();
        if(!empty($this->input['del_sign'])) $this->deleteSignature();

        $this->addPhoto();
        $this->addSignature();

        $this->find($this->profile->id);

    }

    public function delete() {

        $this->deletePhoto();
        $this->deleteSignature();
        $this->query("DELETE FROM ".$this->table." WHERE id = ".$this->profile->id);

    }

    protected function addPhoto() {

        if(!empty($this->files['photo']['name'])) {

            $folder = USER_IMG_PATH_PROFILE;

            $storage = new \Upload\Storage\FileSystem($folder);
            $file = new \Upload\File('photo', $storage);

            $newFilename = uniqid();
            $file->setName($newFilename);

            $file->addValidations(array(
                new \Upload\Validation\Mimetype(array('image/png', 'image/jpg', 'image/jpeg', 'image/gif')),
                new \Upload\Validation\Size('15M')
            ));

            try {
                $file->upload();

                $img = Image::make($folder.$file->getNameWithExtension());
                $img->resize(80, 80);
                $img->save($folder.'sm-'.$file->getNameWithExtension());

                $this->setPhoto($file->getNameWithExtension());

            } catch (\Exception $e) {
                $errors = $file->getErrors();
                print_r($errors);
                if(!empty($errors) && $errors[0] == 'Invalid mimetype') {
                    $_SESSION['errors'][] = "Le format de votre photo est incorrect <br />(JPG, PNG et GIF)";
                }
                if(!empty($errors) && $errors[1] == 'File size is too large') {
                    $_SESSION['errors'][] = "Poids maximum 15Mo";
                }
            }

        }

    }

    public function deletePhoto() {

        if(is_file(USER_IMG_PATH_PROFILE.$this->profile->photo)) {

            unlink(USER_IMG_PATH_PROFILE.$this->profile->photo);
            unlink(USER_IMG_PATH_PROFILE.'sm-'.$this->profile->photo);

            $this->setPhoto('');
            $this->find($this->profile->id);
        }

    }

    protected function setPhoto($photo = null) {

        $sql = "UPDATE ".$this->table." 
                  SET photo = '".$photo."'
                    WHERE id = ".$this->profile->id;
        $this->query($sql);
    }

    protected function addSignature() {

        if(!empty($this->files['signature']['name'])) {

            $folder = USER_IMG_PATH_SIGNATURE;

            $storage = new \Upload\Storage\FileSystem($folder);
            $file = new \Upload\File('signature', $storage);

            $newFilename = uniqid();
            $file->setName($newFilename);

            $file->addValidations(array(
                new \Upload\Validation\Mimetype(array('image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'application/pdf')),
                new \Upload\Validation\Size('15M')
            ));

            try {

                $file->upload();
                $this->setSignature($file->getNameWithExtension());

            } catch (\Exception $e) {

                $errors = $file->getErrors();

                if(!empty($errors) && $errors[0] == 'Invalid mimetype') {
                    $_SESSION['errors'][] = "Le format de votre signature est incorrect <br />(GIF, JPG, PNG, PDF)";
                }
                if(!empty($errors) && $errors[1] == 'File size is too large') {
                    $_SESSION['errors'][] = "Poids maximum 15Mo";
                }
            }

        }

    }

    public function deleteSignature() {

        if(is_file(USER_IMG_PATH_SIGNATURE.$this->profile->signature)) {

            unlink(USER_IMG_PATH_SIGNATURE.$this->profile->signature);

            $this->setSignature('');
            $this->find($this->profile->id);
        }

    }

    protected function setSignature($signature = null) {

        $sql = "UPDATE ".$this->table." 
                  SET signature = '".$signature."'
                    WHERE id = ".$this->profile->id;
        $this->query($sql);
    }

    public function setPassword($value = null) {

        $pass = Lib::createPassword($value);
        $this->profile->password = $pass['password'];

        $this->query("UPDATE ".$this->table." SET password = '".$pass['hash']."' WHERE id = ".$this->profile->id);
        $this->query("UPDATE ".$this->table." SET password_decrypt = '".$pass['password']."' WHERE id = ".$this->profile->id);

        return $pass;

    }

    public function setToken($token) {
        $this->query("UPDATE ".$this->table." SET token = '".$token."' WHERE id = ".$this->profile->id);
    }

    public function formatBirthDate() {

        if (!empty($this->input['birthdate'])) {
            $birthdate = DateTime::createFromFormat('d/m/Y', $this->input['birthdate']);
            return $birthdate->format('Y-m-d');
        }
    }

    public function getProperties($steps = array()) {

        //if(!empty($steps)) $addSql = " AND step IN (".implode(',', $steps).")";

        $sql = "SELECT p.*, dpt.name as type, ps.name as status, ps.class as status_class FROM wagaia_property p
                    LEFT JOIN wagaia_dico_property_type dpt ON dpt.id = p.type_id
                    LEFT JOIN wagaia_property_state ps ON ps.id = p.state
                    WHERE p.user_id = ".$this->profile->id." AND p.step > 2 AND p.deleted_at IS NULL";
        $properties = $this->select($sql, 'id');
        if(!empty($properties)) {
            foreach ($properties as $property) {
                $properties[$property->id]->photos = $this->select("SELECT * FROM wagaia_property_photo WHERE property_id = " . $property->id." ORDER BY is_main DESC");
            }
        }

        return $properties;
    }

}
<?php
namespace App\Utils;

use App\Exception\UploadedFileException;

/**
 * Class UploadedFile
 *
 * Classe que gestiona la pujada de fitxers al servidor mitjançant formularis
 */
class UploadedFile
{
    /**
     * @var array
     *
     * Array del fitxer pujat. $_FILES['nom_del_camp_del_formuari']
     */
    private $file;
    /**
     * @var string
     *
     * Nom amb que es guardarà el fitxer.
     */
    private $fileName;
    /**
     * @var int
     *
     * Mida màxima en bytes del fitxer, 0 indica que no hi ha límit.
     */

    private $maxSize;
    /**
     * @var array
     *
     * Array amb els MimeType acceptats. Per exemple ['image/jpg', 'image/gif', image/png']. Si l'array és buit
     * s'accepten tots els tipus.
     */
    private $acceptedTypes;


    /**
     * UploadedFile constructor.
     * @param array $uploadedFile
     * @param int $maxSize
     * @param array $acceptedTypes
     */
    public function __construct(array $uploadedFile, int $maxSize = 0, array $acceptedTypes = array())

    {
        $this->file = $uploadedFile;
        $this->fileName = $uploadedFile['name'];
        $this->maxSize = $maxSize;
        $this->acceptedTypes = $acceptedTypes;

    }

    /**
     * @return bool
     *
     * Comprova que el fitxer s'haja pujat correctament, que no supera el limit de grandària i és del tipus indicat.
     * Si no passa la validació tornarà false.
     * @throws UploadedFileException
     */
    public function validate(): bool
    {
        if (empty($this->fileName)) return true;

        $urlTemp = $this->file['tmp_name'];
        $size = $this->file['size'];
        $type = $this->file['type'];
        $error = $this->file['error'];

        $maxSize = $this->maxSize;
        $acceptedTypes = $this->acceptedTypes;

        if ($error === UPLOAD_ERR_OK) {
            if (is_uploaded_file($urlTemp) === true) {
                if ($size <= $maxSize) {
                    if (in_array($type, $acceptedTypes)) {
                        return true;
                    } else {
                        throw new UploadedFileException('El tipo  de la imagen' . $type . 'supera el limite establecido' . implode('.', $this->acceptedTypes));
                    }

                } else {
                    throw new UploadedFileException('La grandaria de la imagen es  ' . $size . '  supera el limite establecido' . $this->maxSize);
                }

            } else {
                throw new UploadedFileException('La imagen no es valida');
            }
        }
    }


    /**
     * @return string
     *
     * Tornarà el nom del fitxer.
     */
    public function getFileName(): ?string
    {
        return $this->fileName;

    }


    /**
     * @param string $path
     * @param string $fileName
     * @return bool
     *
     * Guarda el fitxer en la ubicació indicada. Si no s'indica nom es guardarà amb el mateix nom que s'ha penjat.
     * Exemple: $path = '/public/images/', $fileName = 'prova.png'
     *
     * Torna true si s'ha pogut moure la imatge a la ubicació indicada.
     */
    public function save(string $path, $fileName = ""): bool
    {
        if (empty($fileName)) {
            $fileName = $this->fileName;
        }
        return move_uploaded_file($this->file['tmp_name'], $path . $fileName);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use SoapFault;

class ReportController extends Controller
{
    

// soap_debug($client);
    public function client()
    {
        // try {
        //     $oldValue = libxml_disable_entity_loader(false);
        //     $client = new \SoapClient("https://$APICORP_ADDRESS/apiCorp/$COMPANY_NAME?singleWsdl",
        //         array("trace" => 1,
        //             "login" => $LOGIN,
        //             "password" => $PASSWORD,
        //             "soap_version" => SOAP_1_1,
        //             "features" => SOAP_SINGLE_ELEMENT_ARRAYS,
        //         ));
        //     libxml_disable_entity_loader($oldValue);
        //     return $client;
        // } catch (SoapFault $e) {
        //     return response()->json(['success' => false, 'data' => $e], 400);
        //     var_dump($e->getCode());
        //     var_dump($e);
        //     soap_debug($client);
        // }
    }

    public function simpleCheck($path, $author, $ocr)
    {
        $client = $this->client();
        $data = $this->get_doc_data($path);
        $attributes = array(
            "DocumentDescription" => array(
                "Authors" => array(
                    "AuthorName" => array(
                        "OtherNames" => $author->firstname ,
                        "Surname" => $author->lastname,
                        "PersonIDs" => array(
                            "CustomID" => "original",
                        ),
                    ),

                ),
            ),
        );
        $ocrValue = array(
            "OcrExtraction" => False,
        );
        if ($ocr == 'true') {
            $ocrValue = array(
                "OcrExtraction" => True,
            );
        }
        // Загрузка файла
        $uploadResult = $client->UploadDocument(array("data" => $data, "attributes" => $attributes, "options" => $ocrValue));
        // Идентификатор документа. Если загружается не архив, то список загруженных документов будет состоять из одного элемента.
        $id = $uploadResult->UploadDocumentResult->Uploaded[0]->Id;
        $client->CheckDocument(array("docId" => $id));
        return $id;

    }
    public function simpleCheckText($path, $author)
    {
        $client = $this->client();
        $data = $this->get_doc_data($path);
        $attributes = array(
            "DocumentDescription" => array(
                "Authors" => array(
                    "AuthorName" => array(
                        "OtherNames" => $author->firstname,
                        "Surname" => $author->lastname,
                        "PersonIDs" => array(
                            "CustomID" => "original",
                        ),
                    ),

                ),
            ),
        );
        // Загрузка файла
        $uploadResult = $client->UploadDocument(array("data" => $data, "attributes" => $attributes));
        // Идентификатор документа. Если загружается не архив, то список загруженных документов будет состоять из одного элемента.
        $id = $uploadResult->UploadDocumentResult->Uploaded[0]->Id;
        $client->CheckDocument(array("docId" => $id));
        return $id;

    }

    public function checkDoc($id)
    {
        $client = $this->client();
        $id = json_decode($id);
        $status = $client->GetCheckStatus(array("docId" => $id));
        return $status->GetCheckStatusResult;
    }
    // public function OCR($id){
    //     $client = $this->client();
    //     $id = json_decode($id);

    // }

    public function setIndex($id)
    {
        $client = $this->client();
        $id = json_decode($id);
        $client->SetIndexState(array("docId" => $id, "indexState" => 'Indexed'));
    }

    public function removeIndex($id)
    {
        $client = $this->client();
        $id = json_decode($id);
        $client->SetIndexState(array("docId" => $id, "indexState" => 'None'));
    }
    public function deleteDocument($id)
    {
        $client = $this->client();
        $id = json_decode($id);
        $delete = $client->DeleteDocument(array("docId" => $id));
    }
    // public function getOriginality($id)
    // {
    //     $client = $this->client();
    //     $id = json_decode($id);
    //     $original = $client->GetReportView(array("docId" => $id));
    //     return $original->GetReportViewResult->Summary->BaseScore->Unknown;
    // }
    public function getCount($id)
    {
        $client = $this->client();
        $id = json_decode($id);
        $countvalue = array(
            "NeedStats" => True,
        );
        $original = $client->GetDocumentInfo(array("docId" => $id, 'options' => $countvalue));
        return $original->GetDocumentInfoResult->Statistic;
    }

    public function getText($id)
    {
        $client = $this->client();
        $id = json_decode($id);
        $text = $client->GetDocumentText(array("docId" => $id));
        return $text;
    }
}

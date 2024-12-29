<?php

namespace App\Repositories\Interfaces;
/**
 * Define a set of methods that a class must implement in order to satisfy a contract.
 *
 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
 */
interface OfficeInterface
{
    public function getOffices();
    public function getSections();
    public function getTracker();
    public function getLogs();
    public function getReturnedLogs();
    public function getDocuments();
    public function getArchives();
    public function getDocument($request);
    public function getDocType();

    public function createQRCode($request);
    public function renameQRCode($request);
    public function deleteQRCode($request);
    public function forwardDocument($request);
    public function forwardDocumentAgain($request);
    public function forwardSelectedDocument($request);

    public function updateAccountInformation($request);

    public function getOffice($request);

    public function scanDocument($request);
}

?>
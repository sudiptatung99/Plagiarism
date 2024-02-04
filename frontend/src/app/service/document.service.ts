import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { map, catchError } from 'rxjs/operators';
import { Observable, throwError } from 'rxjs';
import { HttpHeaders, HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class DocumentService {

  constructor(private _httpClient: HttpClient) { }

  public baseUrl = environment.BASE_URL;

  public publicHeader() {
    let httpOptionsSecure = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
      })
    };
    return httpOptionsSecure;
  }

  public secureHeader() {
    let httpOptionsSecure = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        Authorization: 'Bearer ' + localStorage.getItem('token')
      })
    };
    return httpOptionsSecure;
  }

  public secureHeaderFile() {
    let httpOptionsSecure = {
      headers: new HttpHeaders({
        Authorization: 'Bearer ' + localStorage.getItem('token')
      })
    };
    return httpOptionsSecure;
  }

  onUploadDocument(formData: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'document/upload', formData, this.secureHeaderFile())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onDocumentUploadDocument(formDataDoc: any) {
    return this._httpClient.post(this.baseUrl + 'document/upload-document', formDataDoc, this.secureHeaderFile())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onDocumentDeleted(documentIdObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'document/delete', documentIdObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onDocumentAddToIndex(documentIdObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'document/add-to-index', documentIdObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onDocumentDeletedFromIndex(documentIdObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'document/deleted-from-index', documentIdObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  moveDocFolder(data: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'document/move', data, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  wordCount(formData: any) {
    return this._httpClient.post(this.baseUrl + 'document/show', formData,  this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  textUpload(data: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'document/text', data, this.secureHeaderFile())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }
  getReport(data: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'document/report', data, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  getDocumentCount(data: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'document/count', data, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

}    
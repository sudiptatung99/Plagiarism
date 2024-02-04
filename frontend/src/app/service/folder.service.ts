import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { map, catchError } from 'rxjs/operators';
import { Observable, throwError } from 'rxjs';
import { HttpHeaders, HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class FolderService {

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

  onCreateFolder(folderObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'folder/create', folderObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onDeleteFolder(folderIdObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'folder/delete', folderIdObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onFolderDetails(folderIdObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'folder/details', folderIdObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onUpdateFolder(folderUpdateObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'folder/update', folderUpdateObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onGetFolder(userObj: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'user/all-folder', userObj, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

  onMoveFolder(data: any): Observable<any> {
    return this._httpClient.post(this.baseUrl + 'folder/move', data, this.secureHeader())
      .pipe(map(res => res), catchError(error => {
        return throwError(error);
      })
      );
  }

}    
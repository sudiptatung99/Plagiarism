import * as pdfjsLib from 'pdfjs-dist';
import { Component, Inject, Input, ViewChild , HostListener } from '@angular/core';
import { NgForm } from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { DocumentService } from 'src/app/service/document.service';
import { FolderService } from 'src/app/service/folder.service';
import { UserService } from 'src/app/service/user.service';
import { DashboardService } from 'src/app/service/dashboard.service';
declare var $: any;

@Component({
  selector: 'app-workspace',
  templateUrl: './workspace.component.html',
  styleUrls: ['./workspace.component.css']
})

export class WorkspaceComponent {

  p: number = 1;
  @ViewChild('documents') document: any;
  fileList: File[] = [];
  listOfFiles: any[] = [];
  userObj: any = {
    user_id: localStorage.getItem('userId')
  }
  pagination: any = 10;
  loader = true;
  loaderBtn = false;
  folder: any = [{}];
  folders: any = [{}];
  textNameChecker: any='';
  textContentChecker: any='';
  folderId: any=null;
  folderNames: any = null;
  type: any;
  folderObj: any = {
    user_id: localStorage.getItem('userId'),
    parent_id: '',
    name: '',
    step: ''
  }
  folder_create = true;
  folderIdObj: any = {
    id: ''
  }
  folderUpdateObj: any = {}
  documentObj: any = {
    user_id: localStorage.getItem('userId')
  };

  documentListArr: any = [{}];
  documents: any = [{}];
  deleteDocument = true;
  currentDocument = false;
  documentAction = false;
  documentIdObj: any = {}
  moveFolderId: any;
  folder_move = false;
  documentFolderIdObj: any;
  documentMoveId: File[] = [];
  documentName: File[] = [];
  //pdf to text convert
  totalWord: any;
  doclength: any;
  ocr: any = false;


  constructor(private _userService: UserService,
    private _folderService: FolderService,
    private _documentService: DocumentService,
    private _spinnerService: NgxSpinnerService,
    private _toastr: ToastrService,
    private _dashboard: DashboardService
  ) {

  }

  onClickFolder(parent_id: any, step: any) {
    this.userObj.folder_id = parent_id;
    this._userService.onGetFolderDocument(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.documentListArr = res.data;
        this.documents = this.documentListArr;
      }
    }, (err) => {
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
    this.folderObj.parent_id = parent_id;
    this.folderObj.step = step;
    this.folder_create = true;
    if (parent_id) {
      this.folderIdObj.id = parent_id;
    }
  }

  onEmptyStep() {
    this._toastr.error('Select your folder first !', 'Error', {
      timeOut: 3000,
      positionClass: 'toast-top-right',
      progressBar: true,
      progressAnimation: 'increasing'
    });
  }

  onCreateFolder(form: NgForm) {
    this._spinnerService.hide();
    this.folderObj.step = this.folderObj.step + 1;
    this._folderService.onCreateFolder(this.folderObj).subscribe(res => {
      if (res.success == true) {
        this._spinnerService.hide();
        form.reset();
        this.folderObj.parent_id = '';
        this.folderObj.step = '';
        this.folder_create = false;
        this.folderIdObj.id = '';
        $("#createFolder").modal("hide");
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      if (err.status == 400) {
        this.folderObj.step = this.folderObj.step - 1;
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onDeleteFolderAction() {
    $("#deleteFolder").modal("show");
  }

  onDeleteFolder() {
    this._spinnerService.hide();
    this._folderService.onDeleteFolder(this.folderIdObj).subscribe(res => {
      if (res.success == true) {
        this._spinnerService.hide();
        this.folderObj.parent_id = '';
        this.folderObj.step = '';
        this.folder_create = false;
        this.folderIdObj.id = '';
        $("#deleteFolder").modal("hide");
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onUpdateFolderAction() {
    this._folderService.onFolderDetails(this.folderIdObj).subscribe(res => {
      if (res.success == true) {
        this.folderUpdateObj.id = res.data.id;
        this.folderUpdateObj.name = res.data.name;
      }
    }, (err) => {
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
    $("#updateFolder").modal("show");
  }

  onUpdateFolder(form: NgForm) {
    this._spinnerService.hide();
    this._folderService.onUpdateFolder(this.folderUpdateObj).subscribe(res => {
      if (res.success == true) {
        this._spinnerService.hide();
        this.folderObj.parent_id = '';
        this.folderObj.step = '';
        this.folder_create = false;
        this.folderIdObj.id = '';
        $("#updateFolder").modal("hide");
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onGetFolder() {
    this._userService.onGetFolder(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.folder = res.data;
      }
    }, (err) => {
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onFileChanged(event: any) {
    for (var i = 0; i <= event.target.files.length - 1; i++) {
      var selectedFile = event.target.files[i];
      this.fileList.push(selectedFile);
      this.listOfFiles.push(selectedFile.name)
    }
    // this.wordCount();
    this.document.nativeElement.value = '';
  }

  removeSelectedFile(index: any) {
    this.listOfFiles.splice(index, 1);
    this.fileList.splice(index, 1);
  }

  folderName(e: any, index: any) {
    const newFileName = e.target.value;
    if (newFileName) {
      const file = this.fileList[index];
      const fileExtension = file.name.split('.').pop();
      const newFile = new File([file], newFileName + '.' + fileExtension, {
        type: file.type
      });
      this.listOfFiles[index] = newFile.name;
      this.fileList[index] = newFile;
    }
  }


  onUploadDocument() {
    this._dashboard.sendClickEvent();
    this._spinnerService.show();
    for (var j = 0; j <= this.fileList.length - 1; j++) {
      const folderName = this.fileList[j].name;
      const formData = new FormData();
      formData.append("document", this.fileList[j]);
      formData.append("user_id", this.documentObj.user_id);
      if (this.folderId) {
        formData.append("folder_id", this.folderId);
      }
      if (this.type) {
        formData.append("type", this.type);
      }
      formData.append("name", folderName);
      formData.append("ocr", this.ocr);
      this._documentService.onUploadDocument(formData).subscribe(res => {
        if (res.success == true) {
          this._dashboard.sendClickEvent();
          $("#staticBackdrop").modal("hide");
          this.fileList = [];
          this.listOfFiles = [];
          this._spinnerService.hide();
          console.log(res);
          
          this._toastr.success(res.msg, 'Success', {
            timeOut: 3000,
            positionClass: 'toast-top-right',
            progressBar: true,
            progressAnimation: 'increasing'
          });
          this.ngOnInit();
        }
      }, (err) => {
        console.log(err);
        
        $("#staticBackdrop").modal("hide");
        this.fileList = [];
        this.listOfFiles = [];
        this._spinnerService.hide();
        if (err.status == 400) {
          this._spinnerService.hide();
          this._toastr.error(err.error.msg, 'Error', {
            timeOut: 3000,
            positionClass: 'toast-top-right',
            progressBar: true,
            progressAnimation: 'increasing'
          });
        }
      })
      setInterval(()=>{},2000)
    }
  }
  documentCancel(){
    this.fileList = [];
    this.listOfFiles = [];
  }

  onGetDocuments() {
    this.deleteDocument = true;
    this.currentDocument = false;
    this.loaderBtn = true;
    this._userService.onGetDocument(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.doclength = res.data;
        this.loaderBtn = false;
        this.documentListArr = res.data;
        this.documents = this.documentListArr;
        setTimeout(() => {
          (document.getElementById('10') as HTMLElement).style.fontWeight = "900"
        }, 1000);
      }
    }, (err) => {
      if (err.status == 400) {
        this.loaderBtn = false;
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onGetDeleteDocuments() {
    this.deleteDocument = false;
    this.currentDocument = true;
    this.loaderBtn = true;
    this._userService.onGetDeleteDocument(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.loaderBtn = false;
        this.documentListArr = res.data;
        this.documents = this.documentListArr;
      }
    }, (err) => {
      if (err.status == 400) {
        this.loaderBtn = false;
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onSearch(e: any) {
    let searchKey = e.target.value;
    if (searchKey) {
      this.documents = this.documentListArr.filter((data: any) => {
        let arrObj: any = data.name;
        let d = JSON.stringify(arrObj);
        if (d.toLowerCase().includes(searchKey.toLowerCase())) return data;
      });
    } else {
      this.documents = this.documentListArr;
    }
  }

  onDocumentAction(event: any, name: any, id: any) {
    if (event.target.checked) {
      this.documentAction = true;
      this.documentIdObj.id = id;
      this.documentMoveId.push(event.target.value);
      this.documentName.push(name)
    } else {
      this.documentAction = false;
      const index = this.documentMoveId.indexOf(event.target.value);
      const indexName = this.documentName.indexOf(name);
      if (index > -1) {
        this.documentMoveId.splice(index, 1);
      }
      if (indexName > -1) {
        this.documentName.splice(index, 1);
      }
    }
  }

  removeCheckedFile(index: any) {
    this.documentName.splice(index, 1);
    this.documentMoveId.splice(index, 1);
  }

  onCheck() {

  }

  onDocumentDeleted() {
    this._spinnerService.hide();
    this._documentService.onDocumentDeleted(this.documentIdObj).subscribe(res => {
      if (res.success == true) {
        this.documentIdObj = {};
        this.documentAction = false;
        this._spinnerService.hide();
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onDocumentAddToIndex() {
    this._spinnerService.hide();
    this._documentService.onDocumentAddToIndex(this.documentIdObj).subscribe(res => {
      if (res.success == true) {
        this.documentIdObj = {};
        this.documentAction = false;
        this._spinnerService.hide();
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onDocumentDeletedFromIndex() {
    this._spinnerService.hide();
    this._documentService.onDocumentDeletedFromIndex(this.documentIdObj).subscribe(res => {
      if (res.success == true) {
        this.documentIdObj = {};
        this.documentAction = false;
        this._spinnerService.hide();
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  OnGetAllFolder() {
    this.loader = true;
    this._folderService.onGetFolder(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.loader = false;
        this.folders = res.data;
      }
    }, (err) => {
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  getFolderId(value: string, name: string): void {
    this.folderNames = name
    this.folderId = value;
    $(".drop").click();
  }
  onSelectedType(value: string): void {
    this.type = value;
  }
  onSelectedOcr(): void {
    if ($("#ocr").is(":checked")) {
      this.ocr = true;
    } else {
      this.ocr = false;
    }
  }

  onMoveFolder() {

  }
  moveFolder(id: any) {
    this.moveFolderId = id;
  }
  moveFolderSubmit() {
    if (!this.moveFolderId) {
      this._toastr.error('Select your child folder first !', 'Error', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
        progressBar: true,
        progressAnimation: 'increasing'
      });
    } else {
      this._folderService.onMoveFolder({ id: this.moveFolderId, parent_id: this.folderIdObj.id }).subscribe(res => {
        if (res.success == true) {
          $("#moveFolder").modal("hide");
          this._toastr.success(res.msg, 'Success', {
            timeOut: 3000,
            positionClass: 'toast-top-right',
            progressBar: true,
            progressAnimation: 'increasing'
          });
          this.ngOnInit();

        }
      }, (err) => {
        if (err.status == 400) {
          this._toastr.error(err.error.msg, 'Error', {
            timeOut: 3000,
            positionClass: 'toast-top-right',
            progressBar: true,
            progressAnimation: 'increasing'
          });
        }
      })
    }
  }

  documentFolderId(id: any) {
    this.documentFolderIdObj = id;
  }

  moveDocument() {
    if (!this.documentFolderIdObj) {
      this._toastr.error('Select your folder first !', 'Error', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
        progressBar: true,
        progressAnimation: 'increasing'
      });
    } else {
      this._documentService.moveDocFolder({ doc_id: this.documentIdObj.id, id: this.documentFolderIdObj }).subscribe(res => {
        if (res.success == true) {
          $("#documentMoveFolder").modal("hide");
          this.documentIdObj = {};
          this.documentFolderIdObj = {};
          this.documentAction = false;
          this._toastr.success(res.msg, 'Success', {
            timeOut: 3000,
            positionClass: 'toast-top-right',
            progressBar: true,
            progressAnimation: 'increasing'
          });
          this.documentAction = false;
          this.documentMoveId = [];
          this.ngOnInit();
        }
      }, (err) => {
        if (err.status == 400) {
          this._toastr.error(err.error.msg, 'Error', {
            timeOut: 3000,
            positionClass: 'toast-top-right',
            progressBar: true,
            progressAnimation: 'increasing'
          });
        }
      })
    }

  }

  selectAll(event: Event): void {
    const isChecked = (event.target as HTMLInputElement).checked;
    this.documents.forEach((item: any) => (item.selected = isChecked));
  }

  textName(event: any) {
    this.textNameChecker = event?.target.value;
  }
  cancleTextChecker(){
    this.textNameChecker='';
    this.textContentChecker='';
  }
  textContent(event: any) {
    this.textContentChecker = event?.target.value;
  }

  textChecker() {
    this._spinnerService.show();
    this._dashboard.sendClickEvent();
    this._documentService.textUpload({ folder_id: this.userObj.folder_id, user_id: this.userObj.user_id, name: `${this.textNameChecker}`, text: this.textContentChecker }).subscribe(res => {
      if (res.success == true) {
        this._dashboard.sendClickEvent();
        this._spinnerService.hide();
        this.textContentChecker = null;
        this.textNameChecker = null;
        $('#staticBackdrop2').modal("hide");
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      console.log(err);
      
      this._spinnerService.hide();
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
    // }
  }

  reportGenerate(url: any, id: any) {
    this._spinnerService.show();
    this._documentService.getReport({ doc: url, id: id, user_id: this.userObj.user_id }).subscribe(res => {

      if (res.success == true) {
        this._spinnerService.hide();
        let url = res.data;
        window.open(url, "_blank");
      }
      this.ngOnInit();
    }, (err) => {
      this._spinnerService.hide();
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  pageCount(data: any) {
    this.pagination = data;
    (document.getElementById(`${data}`) as HTMLElement).style.fontWeight = "900"
    if (data != 10) {
      (document.getElementById("10") as HTMLElement).style.fontWeight = ""
    }
    if (data != 20) {
      (document.getElementById("20") as HTMLElement).style.fontWeight = ""
    }
    if (data != 50) {
      (document.getElementById("50") as HTMLElement).style.fontWeight = ""
    }
    if (data != 100) {
      (document.getElementById("100") as HTMLElement).style.fontWeight = ""
    }
  }



  ngOnInit(): void {
    this.onGetFolder();
    this.onGetDocuments();
    this.OnGetAllFolder();
  }
 

}

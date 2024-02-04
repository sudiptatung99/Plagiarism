import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DocumentService } from 'src/app/service/document.service';

@Component({
  selector: 'app-thank-you',
  templateUrl: './thank-you.component.html',
  styleUrls: ['./thank-you.component.css']
})
export class ThankYouComponent {
  document: any;
  isLoader = false;
  constructor(private _document: DocumentService,
    private route: ActivatedRoute) {
  }

  getDocumentCount() {
    this.isLoader = true;
    this._document.getDocumentCount({ id: this.route.snapshot.paramMap.get('id') }).subscribe((res) => {
      if(res.success==true){
        this.isLoader = false;
        this.document = res.data
      }
    }, err => {
      this.isLoader = false;
    })
  }
  ngOnInit(): void { 
    this.getDocumentCount();
  }

}

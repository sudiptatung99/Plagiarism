import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DocumentService } from 'src/app/service/document.service';
import { DomSanitizer } from '@angular/platform-browser';

@Component({
  selector: 'app-pdf-reading',
  templateUrl: './pdf-reading.component.html',
  styleUrls: ['./pdf-reading.component.css']
})
export class PdfReadingComponent {
  documentDetails: any = {};
  page: any;
  word: any;
  sentence: any;
  letter: any;
  text: any;
  textLength: any;
  Textsize: any;
  pdfView: any;
  pageNo: any;
  loading = false;
  loader = true;
  constructor(private route: ActivatedRoute,
    private _documentService: DocumentService,
    private sanitizer: DomSanitizer) { }

  wordCount() {
    this.loader = true;
    this._documentService.wordCount({ id: this.route.snapshot.paramMap.get('id') }).subscribe((response: any) => {
      console.log(response);

      if (response.success == true) {
        this.loader = false;
        this.page = response.page;
        this.word = response.word;
        this.sentence = response.sentence;
        this.letter = response.letter;
        this.text = response.text;
        this.pageNo = response.page;
        this.pdfView = response.details.document;
        this.Textsize = response.size / 1024;
        this.textLength = parseInt(this.Textsize).toFixed(2)
        this.documentDetails = response.details;
      }
    }, (err) => {
      this.loader = false;

    })
  }

  original_view() {
    this.loading = true;
    setTimeout(() => {
      this.loading = false;
    }, 5000);

  }

  ngOnInit() {
    this.wordCount();

  }

}

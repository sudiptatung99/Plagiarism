import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PdfReadingComponent } from './pdf-reading.component';

describe('PdfReadingComponent', () => {
  let component: PdfReadingComponent;
  let fixture: ComponentFixture<PdfReadingComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [PdfReadingComponent]
    });
    fixture = TestBed.createComponent(PdfReadingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

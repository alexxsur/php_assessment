import { Injectable } from '@angular/core';
import { Subject, filter } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ServicesRequestService {
  subject = new Subject();
  constructor(private httpRequest: HttpClient) { }

  public searchByFilter(filter:any){
    //this.httpRequest.get<any>();
    console.log(filter);
    this.subject.next("LA LISTAAA");
  }

  public getObservable(): Subject<any>{
    return this.subject;
  }

}

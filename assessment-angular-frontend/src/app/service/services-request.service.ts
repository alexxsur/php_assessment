import { Injectable } from '@angular/core';
import { Subject} from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ServicesRequestService {
  subject = new Subject();
  constructor(private http: HttpClient) { }

  public searchByFilter(filter:any){

    let ramFilterString = '';
    let ramCheckedValues = filter.ramCheckFilter.filter((ramCheckItem: any) => ramCheckItem.active);

    for (const item of ramCheckedValues) {
        ramFilterString = `${ramFilterString}${ramFilterString != '' ? '&' : ''}ram[]=${item.ramCapacity}`;
    }

    let apiHost = 'http://localhost:8000';
    let apiEndpoint = '/server';
    let filtersString = '';

    console.log(ramFilterString);

    if (ramFilterString !== '' && filter.hddType !== '' && filter.location !== '') {
      filtersString = `?storage=${filter.rangeStorage}&hdd_type=${filter.hddType}&location=${filter.location}&${ramFilterString}`;
    } else if (ramFilterString !== '' && filter.hddType !== '') {
      filtersString = `?storage=${filter.rangeStorage}&hdd_type=${filter.hddType}&${ramFilterString}`;
    } else if (filter.location !== '' && filter.hddType !== '') {
      filtersString = `?storage=${filter.rangeStorage}&hdd_type=${filter.hddType}&location=${filter.location}`;
    } else if (ramFilterString !== '' && filter.location !== '') {
      filtersString = `?storage=${filter.rangeStorage}&location=${filter.location}&${ramFilterString}`;
    } else if (ramFilterString !== '') {
      filtersString = `?storage=${filter.rangeStorage}&${ramFilterString}`;
    } else if (filter.hddType !== '') {
      filtersString = `?storage=${filter.rangeStorage}&hdd_type=${filter.hddType}`;
    } else if (filter.location !== '') {
      filtersString = `?storage=${filter.rangeStorage}&location=${filter.location}`;
    } else {
      filtersString = `?storage=${filter.rangeStorage}`;
    }

    let urlServerQueryString = `${apiHost}${apiEndpoint}${filtersString}`;

    console.log(urlServerQueryString);

    this.http.get<any>(urlServerQueryString).subscribe(data => {
        console.log(data);
       this.subject.next(data);
    })

  }

  public getObservable(): Subject<any>{
    return this.subject;
  }

}

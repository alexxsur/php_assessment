import { Component, OnInit} from '@angular/core';
import { ServicesRequestService } from 'src/app/service/services-request.service';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-mainlist',
  templateUrl: './mainlist.component.html',
  styleUrls: ['./mainlist.component.css']
})
export class MainlistComponent implements OnInit{

  itemsList : any[] = [];
  locationsList : any[] = [];
  rangeStorage:number = 250;
  hddType: string = '';
  location: string = '';
  ramCheckFilter: any[] = [
    {label: "2GB", ramCapacity: 2, active: false},
    {label: "4GB", ramCapacity: 4, active: false},
    {label: "8GB", ramCapacity: 8, active: false},
    {label: "12GB", ramCapacity: 12, active: false},
    {label: "16GB", ramCapacity: 16, active: false},
    {label: "24GB", ramCapacity: 24, active: false},
    {label: "32GB", ramCapacity: 32, active: false},
    {label: "48GB", ramCapacity: 48, active: false},
    {label: "64GB", ramCapacity: 64, active: false},
    {label: "96GB", ramCapacity: 96, active: false},
  ]

  constructor( private servicesRequest: ServicesRequestService, private http: HttpClient){

  }
  ngOnInit(): void {

    this.servicesRequest.getObservable()
      .subscribe({
        next: (value) => {
          this.itemsList = value;
        },
      });

    let urlServerQueryString = 'http://127.0.0.1:8000/server/locations';

    this.http.get<any>(urlServerQueryString).subscribe(data => {
        console.log(data);
        this.locationsList = data;
    })

    this.applyFilter();
  }

  onCheckboxChange(item: any, index: number): void{
    //console.log("item:", item);
    //console.log("index:" + index);
    this.ramCheckFilter[index].active = !item.active;
    //console.log(this.ramCheckFilter);
    this.applyFilter();

  }
  onChangeRangeStorage(rangeSelected: any): void{
    //console.log(rangeSelected);
    this.rangeStorage = rangeSelected;

    if (rangeSelected <= 18.8) {
      rangeSelected = (rangeSelected/9.09)*250;
    } else if(rangeSelected <= 45.45){
      rangeSelected = ((rangeSelected/9.09) - 2)*1000;
    } else if(rangeSelected <= 72.72){
      rangeSelected = ((rangeSelected/9.09) - 4)*4000 - 4000;
    } else if(rangeSelected <= 81.81){
      rangeSelected = ((rangeSelected/9.09) -6)*12000 - 12000;
    } else if(rangeSelected <= 90.90){
      rangeSelected = ((rangeSelected/9.09) -8)*48000 - 48000;
    } else if(rangeSelected <= 100){
      rangeSelected = ((rangeSelected/9.09) -10)*72000;
    }

    console.log(rangeSelected);

    this.rangeStorage = rangeSelected;
    this.applyFilter();

  }
  onChangeHardDrive(selectedValue: any): void{
    //console.log(selectedValue.value);
    this.hddType = selectedValue.value;
    this.applyFilter();
  }

  onChangeLocation(selectedValue: any): void{
    //console.log(selectedValue.value);
    this.location = selectedValue.value;
    this.applyFilter();
  }

  applyFilter(): void{
    let filterObject = {
      rangeStorage   : this.rangeStorage,
      hddType        : this.hddType,
      location       : this.location,
      ramCheckFilter : this.ramCheckFilter,
    }
    this.servicesRequest.searchByFilter(filterObject);
  }

}
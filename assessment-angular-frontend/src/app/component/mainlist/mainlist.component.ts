import { Component, OnInit} from '@angular/core';
import { ServicesRequestService } from 'src/app/service/services-request.service';

@Component({
  selector: 'app-mainlist',
  templateUrl: './mainlist.component.html',
  styleUrls: ['./mainlist.component.css']
})
export class MainlistComponent implements OnInit{

  range:number = 0;
  hardDrive: String = '';
  location: String = '';
  filterCheck: any[] = [
    {label: "2GB", value: false},
    {label: "4GB", value: false},
    {label: "8GB", value: false},
    {label: "12GB", value: false},
    {label: "16GB", value: false},
    {label: "24GB", value: false},
    {label: "32GB", value: false},
    {label: "48GB", value: false},
    {label: "64GB", value: false},
    {label: "96GB", value: false},
  ]

  constructor( private servicesRequest: ServicesRequestService){

  }
  ngOnInit(): void {

    this.servicesRequest.getObservable()
      .subscribe({
        next: (v) => {
          console.log(v);
        },
      });

  }

  onCheckboxChange(item: any, index: number): void{
    console.log("item:", item);
    console.log("index:" + index);
    this.filterCheck[index].value = !item.value;
    console.log(this.filterCheck);
    this.applyFilter();

  }
  onChangeRangeStorage(rangeSelected: any): void{
    console.log(rangeSelected);
    this.applyFilter();

  }
  onChangeHardDrive(valuSelected: any): void{
    console.log(valuSelected.value);
    this.hardDrive = valuSelected.value;
    this.applyFilter();
  }

  onChangeLocation(valuSelected: any): void{
    console.log(valuSelected.value);
    this.location = valuSelected.value;
    this.applyFilter();
  }

  websiteList: any = ['Javatpoint.com', 'HDTuto.com', 'Tutorialandexample.com']; 

  applyFilter(): void{
    this.servicesRequest.searchByFilter(this.hardDrive);
  }

}
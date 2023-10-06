import { TestBed } from '@angular/core/testing';

import { ServicesRequestService } from './services-request.service';

describe('ServicesRequestService', () => {
  let service: ServicesRequestService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ServicesRequestService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});

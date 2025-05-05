select * from costingdetail where yield=0 or yield is null;
update costingdetail set yield=1 where yield=0 or yield is null ;

select * from costingdetail where allowance is null;
update costingdetail set allowance=0 where allowance is null ;



select * from costingdetail where qty is null;
update costingdetail set qty=0 where qty is null ;

select itemid,qty,yield,allowance,req_qty,total,categoryid from costingdetail;


select itemid,qty,yield,allowance,req_qty,total,categoryid from costingdetail where categoryid<>6;
update costingdetail set req_qty=(ROUND(CAST(((qty/yield)*(1+allowance)) AS NUMERIC), 3)) where qty>0 and categoryid<>6;


select itemid,qty,yield,allowance,req_qty,total,categoryid from costingdetail where categoryid=6;


update costingdetail set req_qty=(ROUND(CAST((qty*yield) AS NUMERIC), 3)) where qty>0 and categoryid=6;

update costingdetail set req_qty=0 where qty=0;
-- Function: public.costing_load_all(bigint, bigint)

-- DROP FUNCTION public.costing_load_all(bigint, bigint);

CREATE OR REPLACE FUNCTION public.costing_load_all(
    _costingid bigint,
    _modelid bigint)
  RETURNS void AS
$BODY$
declare
	_itemid bigint;
	_itemcode character varying := '';
	_itemdescription varchar := '';
	_unitid bigint;
	_unitcode character varying := '';
	_qty double precision;
	_req_qty double precision;
	_price double precision;
	_curr varchar := '';
	_yield double precision;
	_allowance double precision;
	_pricerp double precision;
	_priceusd double precision;
	
	_sql text := '';
	_sqlglass text := '';
	_sqlmarble text := '';
	_sqlinlay text := '';
	_sqlplywood text := '';
	
	
	_costingcategoryid bigint := 0 ;
begin
	update costing set fob_price=0,sellprice=0,direct_material=0,direct_labour=0,fixed_cost_value=0,pick_list_hardware=0,sub_contractor=0,port_origin_cost_value=0,sub_total=0
		where id=_costingid;
	for _costingcategoryid in 
		select id from costingcategory
	loop
		if _costingcategoryid = 10 then --Sub Contractor
			--select costing_loaddirectlabour(_costingid) as ct;
		
		elsif _costingcategoryid = 9 then --Direct Labour
		/*	
			delete from costingdetail where costingid=_costingid and categoryid = 9 and (qty is null or qty = 0);
			for _itemid,_itemdescription,_unitcode,_price in (
				--insert hanya yg belum di edit qty nya
				select id,description,unit,price from directlabour where id not in (
					select itemid from costingdetail where costingid=_costingid and categoryid = 9 and qty > 0
				)	 
				order by description asc
			) 
			loop
				insert into costingdetail(materialcode,uom,unitpricerp,costingid,categoryid,itemid,allowance) values (_itemdescription,_unitcode,_price,_costingid,9,_itemid,0.1);
			end loop;
		*/
		elsif _costingcategoryid = 6 then -- Finishing dr model

		
		else
			_sqlglass := '';
			_sqlmarble := '';
			_sqlinlay := '';	
			_sqlplywood := '';		
			_sql := 'select 
				modelmaterial.itemid,
				item.partnumber,
				item.descriptions,
				(select item_get_smallest_unit(modelmaterial.itemid)) unitcode,
				modelmaterial.qty,
				item.curr,
				item.price
				from modelmaterial
				join item on modelmaterial.itemid=item.id and modelmaterial.modelid=' || _modelid;			
			if _costingcategoryid = 1 then -- Board (utk PRT,MDF,PLY wood)
				_sql := _sql || ' and item.groupsid in (4,5,6)';
			elsif _costingcategoryid = 2 then --Veneer
				_sql = 'select modelveneer.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelveneer.cutting_list as qty,modelveneer.yield,modelveneer.qty as req_qty,
					item.curr,item.price
					from modelveneer join item on modelveneer.itemid=item.id join unit on modelveneer.unitid=unit.id and modelveneer.modelid=' || _modelid;
			elsif _costingcategoryid = 3 then --Solid Wood
				_sql = 'select modelsolidwood.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelsolidwood.cutting_list as qty,modelsolidwood.yield,modelsolidwood.qty as req_qty,
					item.curr,item.price
					from modelsolidwood join item on modelsolidwood.itemid=item.id join unit on modelsolidwood.unitid=unit.id and modelsolidwood.modelid=' || _modelid;
			elsif _costingcategoryid = 4 then --HARDWARE non Picklist
				_sql = 'select modelhardware.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelhardware.qty,modelhardware.yield,
					item.curr,item.price
					from modelhardware join item on modelhardware.itemid=item.id join unit on modelhardware.unitid=unit.id 
					and modelhardware.modelid=' || _modelid || ' and modelhardware.is_picklist=false and modelhardware.hardwaretypeid in (1,2,4) ';
			elsif _costingcategoryid = 8 then --Picklist
				_sql = 'select modelhardware.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelhardware.qty,modelhardware.yield,
					item.curr,item.price
					from modelhardware join item on modelhardware.itemid=item.id join unit on modelhardware.unitid=unit.id 
					and modelhardware.modelid=' || _modelid || ' and modelhardware.is_picklist=true ';
				_sqlglass = 'select modelglass.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelglass.qty,
					item.curr,item.price
					from modelglass join item on modelglass.itemid=item.id join unit on modelglass.unitid=unit.id and modelglass.modelid=' || _modelid;
				_sqlmarble = 'select modelmarble.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelmarble.qty,
					item.curr,item.price
					from modelmarble join item on modelmarble.itemid=item.id join unit on modelmarble.unitid=unit.id and modelmarble.modelid=' || _modelid;
				_sqlinlay = 'select modellatherinlay.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modellatherinlay.qty,
					item.curr,item.price
					from modellatherinlay join item on modellatherinlay.itemid=item.id join unit on modellatherinlay.unitid=unit.id and modellatherinlay.modelid=' || _modelid;
				_sqlplywood = 'select modelplywood.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelplywood.cutting_list as qty,modelplywood.yield,modelplywood.qty as req_qty,
					item.curr,item.price
					from modelplywood join item on modelplywood.itemid=item.id join unit on modelplywood.unitid=unit.id and modelplywood.modelid=' || _modelid;
					
			elsif _costingcategoryid = 5 then -- Upholstery
				_sql = 'select modelhardware.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelhardware.qty,modelhardware.yield,
						item.curr,item.price
					from modelhardware join item on modelhardware.itemid=item.id join unit on modelhardware.unitid=unit.id 
					and modelhardware.modelid=' || _modelid || ' and modelhardware.hardwaretypeid in (3) and modelhardware.is_picklist=false ';
			elsif _costingcategoryid = 7 then --Packing
				_sql = 'select modelpacking.itemid,item.partnumber,item.descriptions,unit.codes unitcode,modelpacking.qty,
						item.curr,item.price
					from modelpacking join item on modelpacking.itemid=item.id join unit on modelpacking.unitid=unit.id and modelpacking.modelid=' || _modelid;		
			end if;		
		
			--raise notice 'val: %',_sql;
			
			/*
			 * DELETE DATA before Insert in costing detail
			 */
			
			delete from costingdetail where costingid=_costingid and categoryid=_costingcategoryid and (source != 'Default' or source is null) and uom!='HOUR';
			if  _costingcategoryid = 1 or  _costingcategoryid = 7  then --material n packing
				
				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_curr,_price in 
					execute _sql
				loop
					/* DELETE item DEFAULT, jika ada, untuk meminimalisir duplikasi item dengan item dr model*/
					delete from costingdetail where costingid=_costingid and categoryid=_costingcategoryid and itemid=_itemid and source = 'Default';
					
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
					if _qty is NULL then
						_qty=0;
					end if;
				
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,unitpricerp,unitpriceusd,allowance,yield,req_qty) values 
					(_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_pricerp,_priceusd,0,1,_qty);
				end loop;
				
			elseif  _costingcategoryid = 2 or  _costingcategoryid = 3  then --Veener & Solid Wood
				
				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_yield,_req_qty,_curr,_price in 
					execute _sql
				loop
					/* DELETE item DEFAULT, jika ada, untuk meminimalisir duplikasi item dengan item dr model*/
					delete from costingdetail where costingid=_costingid and categoryid=_costingcategoryid and itemid=_itemid and source = 'Default';
					
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
					if _yield is NULL then
						_yield=0;
					end if;
					if _qty is NULL then
						_qty=0;
					end if;
					if _req_qty is NULL then
						_req_qty=0;
					end if;
					--raise notice 'categoryid=% itemid=% materialcode=% price=% dan cur=% materialdescription=% uom=% unitpricerp=% unitpriceusd=% qty=% req_qty=% yield=% cur=%' ,
					--_costingcategoryid,_itemid,_itemcode,_price,_curr,_itemdescription,_unitcode,_pricerp,_priceusd,_qty,_req_qty,_yield,_curr;
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,yield,req_qty,unitpricerp,unitpriceusd,allowance) values 
					(_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_yield,_req_qty,_pricerp,_priceusd,0);
				end loop;
				
			elseif  _costingcategoryid = 4 then --hardware
				
				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_yield,_curr,_price in 
					execute _sql
				loop
					/* DELETE item DEFAULT, jika ada, untuk meminimalisir duplikasi item dengan item dr model*/
					delete from costingdetail where costingid=_costingid and categoryid=_costingcategoryid and itemid=_itemid and source = 'Default';
					
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
					if _yield is NULL then
						_yield=0;
					end if;
					if _qty is NULL then
						_qty=0;
					end if;
					_req_qty=(_qty+(_qty*0.025));
				
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,unitpricerp,unitpriceusd,allowance,yield,req_qty) values 
					(_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_pricerp,_priceusd,0.025,1,_req_qty);
				end loop;
			elseif  _costingcategoryid = 8 then --picklist
				
				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_yield,_curr,_price in 
					execute _sql
				loop
					/* DELETE item DEFAULT, jika ada, untuk meminimalisir duplikasi item dengan item dr model*/
					delete from costingdetail where costingid=_costingid and categoryid=_costingcategoryid and itemid=_itemid and source = 'Default';
					
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
					if _yield is NULL then
						_yield=0;
					end if;
					raise notice 'insert into costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,unitpricerp,unitpriceusd,allowance,yield,req_qty) values(%,%,%,%,%,%,%,%,%,0,1,%)',
							_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_pricerp,_priceusd,_qty;
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,unitpricerp,unitpriceusd,allowance,yield,req_qty) values 
					(_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_pricerp,_priceusd,0,1,_qty);
				end loop;
				
				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_curr,_price in 
					execute _sqlglass
				loop
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
					if _yield is NULL then
						_yield=0;
					end if;
					if _qty is NULL then
						_qty=0;
					end if;
					_req_qty=(_qty+(_qty*0.1));
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,unitpricerp,unitpriceusd,allowance,yield,req_qty) values 
					(_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_pricerp,_priceusd,0.1,0,_req_qty);
				end loop;

				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_curr,_price in 
					execute _sqlmarble
				loop
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
					if _yield is NULL then
						_yield=0;
					end if;
					if _qty is NULL then
						_qty=0;
					end if;
					_req_qty=(_qty+(_qty*0.1));
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,unitpricerp,unitpriceusd,allowance,yield,req_qty) values 
					(_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_pricerp,_priceusd,0.1,0,_req_qty);
				end loop;			
				
				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_curr,_price in 
					execute _sqlinlay
				loop
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
					if _yield is NULL then
						_yield=0;
					end if;
					if _qty is NULL then
						_qty=0;
					end if;
					_req_qty=(_qty+(_qty*0.1));
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,unitpricerp,unitpriceusd,allowance,yield,req_qty) values 
					(_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_pricerp,_priceusd,0.1,0,_req_qty);
				end loop;
							
				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_yield,_req_qty,_curr,_price in 
					execute _sqlplywood
				loop
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
				
					if _yield is NULL then
						_yield=0;
					end if;
					if _qty is NULL then
						_qty=0;
					end if;
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,yield,req_qty,unitpricerp,unitpriceusd,allowance) values 
					(_costingid,'1',_itemid,_itemcode,_itemdescription,_unitcode,_qty,_yield,_req_qty,_pricerp,_priceusd,0);
				end loop;

			else  
				for _itemid,_itemcode,_itemdescription,_unitcode,_qty,_yield,_curr,_price in 
					execute _sql
				loop
					/* DELETE item DEFAULT, jika ada, untuk meminimalisir duplikasi item dengan item dr model*/
					delete from costingdetail where costingid=_costingid and categoryid=_costingcategoryid and itemid=_itemid and source = 'Default';
					
					if _curr = 'IDR' then
						_pricerp = _price;
						_priceusd = 0;
					else -- USD
						_priceusd = _price;
						_pricerp = 0;
					end if;
					if _yield is NULL then
						_yield=0;
					end if;
					if _qty is NULL then
						_qty=0;
					end if;
					if _req_qty is NULL then
						_req_qty=0;
					end if;
				
					insert into 
					costingdetail(costingid,categoryid,itemid,materialcode,materialdescription,uom,qty,unitpricerp,unitpriceusd,allowance,yield,req_qty) values 
					(_costingid,_costingcategoryid,_itemid,_itemcode,_itemdescription,_unitcode,_qty,_pricerp,_priceusd,0,_yield,_qty);
				end loop;
			end if;
			
			
			
		end if;
	end loop;

end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.costing_load_all(bigint, bigint)
  OWNER TO postgres;

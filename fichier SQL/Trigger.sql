create or replace trigger representation_Trigger_delete
after delete  on  LesRepresentations
FOR EACH ROW
begin
   delete from LesTickets 
   where daterep = :old.daterep and noSpec = :old.noSpec;
end;
/

create or replace trigger representation_trigger_Update
after update or insert on LesRepresentations
FOR EACH ROW
begin
   update LesTickets
   set daterep = :new.daterep, noSpec = :new.noSpec
   where daterep = :old.daterep and noSpec = :old.noSpec;
end;
/

from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from fastapi import HTTPException
from app.db.models.sucursal import Sucursal
from app.schemas.sucursal import SucursalCreate

async def get_sucursales(db: AsyncSession):
    result = await db.execute(select(Sucursal))
    return result.scalars().all()

async def get_sucursal_by_id(db: AsyncSession, sucursal_id: int):
    result = await db.execute(select(Sucursal).where(Sucursal.id_sucursal == sucursal_id))
    return result.scalars().first()

async def create_sucursal(db: AsyncSession, data: SucursalCreate):
    sucursal = Sucursal(**data.model_dump())
    db.add(sucursal)
    await db.commit()
    await db.refresh(sucursal)
    return sucursal
async def update_sucursal(db: AsyncSession, sucursal_id: int, data: SucursalCreate):
    sucursal = await get_sucursal_by_id(db, sucursal_id)
    if not sucursal:
        raise HTTPException(status_code=404, detail="Sucursal no encontrada")
    sucursal.nombre = data.nombre  # type: ignore
    sucursal.direccion = data.direccion  # type: ignore
    sucursal.telefono = data.telefono  # type: ignore
    sucursal.ciudad = data.ciudad  # type: ignore
    
    await db.commit()
    await db.refresh(sucursal)
    return sucursal

async def delete_sucursal(db: AsyncSession, sucursal_id: int):
    sucursal = await get_sucursal_by_id(db, sucursal_id)
    if not sucursal:
        raise HTTPException(status_code=404, detail="Sucursal no encontrada")
    await db.delete(sucursal)
    await db.commit()
    return sucursal
from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from fastapi import HTTPException
from app.db.models.rol import Rol
from app.schemas.rol import RolCreate

async def get_roles(db: AsyncSession):
    result = await db.execute(select(Rol))
    return result.scalars().all()

async def get_rol_by_id(db: AsyncSession, rol_id: int):
    result = await db.execute(select(Rol).where(Rol.id_rol == rol_id))
    return result.scalars().first()

async def create_rol(db: AsyncSession, data: RolCreate):
    rol = Rol(**data.model_dump())
    db.add(rol)
    await db.commit()
    await db.refresh(rol)
    return rol

async def update_rol(db: AsyncSession, rol_id: int, data: RolCreate):
    rol = await get_rol_by_id(db, rol_id)
    if not rol:
        raise HTTPException(status_code=404, detail="Rol no encontrado")
    rol.nombre = data.nombre  # type: ignore
    await db.commit()
    await db.refresh(rol)
    return rol

async def delete_rol(db: AsyncSession, rol_id: int):
    rol = await get_rol_by_id(db, rol_id)
    if not rol:
        raise HTTPException(status_code=404, detail="Rol no encontrado")
    await db.delete(rol)
    await db.commit()
    return rol
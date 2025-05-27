from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from app.db.models.rol import Rol
from app.schemas.rol import RolCreate

async def get_roles(db: AsyncSession):
    result = await db.execute(select(Rol))
    return result.scalars().all()

async def create_rol(db: AsyncSession, data: RolCreate):
    rol = Rol(**data.dict())
    db.add(rol)
    await db.commit()
    await db.refresh(rol)
    return rol
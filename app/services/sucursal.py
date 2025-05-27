from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from app.db.models.sucursal import Sucursal
from app.schemas.sucursal import SucursalCreate

async def get_sucursales(db: AsyncSession):
    result = await db.execute(select(Sucursal))
    return result.scalars().all()

async def create_sucursal(db: AsyncSession, data: SucursalCreate):
    sucursal = Sucursal(**data.dict())
    db.add(sucursal)
    await db.commit()
    await db.refresh(sucursal)
    return sucursal